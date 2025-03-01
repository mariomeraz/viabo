<?php declare(strict_types=1);


namespace Viabo\management\receipt\application\delete;


use Viabo\management\receipt\domain\ReceiptRepository;
use Viabo\shared\domain\uploadFile\UploadFileRepository;

final readonly class ReceiptDeleter
{
    public function __construct(
        private ReceiptRepository $repository,
        private UploadFileRepository $uploadFileRepository,
    )
    {
    }

    public function __invoke(string $receiptId): void
    {
        $receipt = $this->repository->search($receiptId);

        if (!empty($receipt)) {
            $this->uploadFileRepository->removeDirectory($receipt->directoryPath());
            $this->repository->delete($receipt);
        }
    }

}