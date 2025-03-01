<?php declare(strict_types=1);


namespace Viabo\management\receipt\application\create;


use Viabo\management\cardMovement\domain\exceptions\CardsMovementsEmpty;
use Viabo\management\receipt\domain\Receipt;
use Viabo\management\receipt\domain\ReceiptRepository;
use Viabo\management\receipt\domain\services\EnsureReceipt;
use Viabo\management\receipt\domain\services\FilesDataFinder;
use Viabo\management\receipt\domain\services\InvoiceDataFinder;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\uploadFile\UploadFileRepository;
use Viabo\shared\domain\utils\NumberFormat;

final readonly class ReceiptCreator
{

    public function __construct(
        private ReceiptRepository    $repository ,
        private UploadFileRepository $uploadFileRepository ,
        private FilesDataFinder      $filesDataFinder ,
        private InvoiceDataFinder    $invoiceDataFinder ,
        private EnsureReceipt        $ensureReceipt ,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(
        string $receiptId ,
        string $userId ,
        string $cardMovements ,
        string $note ,
        array  $files ,
        bool   $isInvoice
    ): void
    {
        $cardMovements = $this->toArray($cardMovements);
        $this->ensureCardsMovements($cardMovements);
        $amountTotal = $this->amountTotal($cardMovements);
        $filesData = $this->filesDataFinder->__invoke($files);
        $invoiceData = $this->invoiceDataFinder->__invoke($files);

        $receipt = Receipt::create(
            $receiptId ,
            $amountTotal ,
            $note ,
            $files ,
            $filesData ,
            $invoiceData ,
            $userId
        );
        $this->ensureReceipt->__invoke($receipt , $this->commercesIds($cardMovements) , $isInvoice);
        $this->save($receipt);

        $this->bus->publish(...$receipt->pullDomainEvents());
    }

    private function toArray(string $cardMovements): array
    {
        return empty($cardMovements) ? [] : json_decode($cardMovements , true);
    }

    private function ensureCardsMovements(array $cardMovements): void
    {
        if (empty($cardMovements)) {
            throw new CardsMovementsEmpty();
        }
    }

    private function amountTotal(array $cardMovements): float|int
    {
        $total = array_sum(array_map(function (array $movement) {
            return floatval($movement['amount']);
        } , $cardMovements));

        return NumberFormat::float($total);
    }

    private function commercesIds(array $cardMovements): array
    {
        return array_map(function (array $cardMovement) {
            return $cardMovement['cardCommerceId'];
        } , $cardMovements);
    }

    private function save(Receipt $receipt): void
    {
        $this->repository->save($receipt);
        array_map(function (object $file) use ($receipt) {
            $this->uploadFileRepository->upload($file , $receipt->directoryPath() , $receipt->filesExtensions());
        } , $receipt->originalFiles());
    }

}