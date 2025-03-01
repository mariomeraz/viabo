<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\services;


use Viabo\backoffice\company\application\find\CommerceQuery;
use Viabo\management\receipt\domain\exceptions\ReceiptFilesOrNoteInvalid;
use Viabo\management\receipt\domain\exceptions\ReceiptNotMatchTheInvoiceAmount;
use Viabo\management\receipt\domain\exceptions\ReceiptToInvoiceFilesInvalid;
use Viabo\management\receipt\domain\exceptions\ReceiptInvoiceRFCInvalid;
use Viabo\management\receipt\domain\Receipt;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class EnsureReceipt
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(Receipt $receipt , array $cardsIds , bool $isInvoice): void
    {
        if ($isInvoice) {
            $this->ensureTheNecessaryFilesToInvoice($receipt);
            $this->ensureInvoiceTotal($receipt);
            $this->ensureInvoiceRFC($receipt , $cardsIds);
        } else {
            $this->ensureFileOrNote($receipt);
        }
    }

    private function ensureTheNecessaryFilesToInvoice(Receipt $receipt): void
    {
        if ($receipt->hasNotTheNecessaryFilesForAnInvoice()) {
            throw new ReceiptToInvoiceFilesInvalid();
        }
    }

    private function ensureInvoiceTotal(Receipt $receipt): void
    {
        if ($receipt->isNotMatchTheInvoiceAmount()) {
            throw new ReceiptNotMatchTheInvoiceAmount();
        }
    }

    private function ensureInvoiceRFC(Receipt $receipt , array $commercesIds): void
    {
        foreach ($commercesIds as $commerceId) {
            $commerceRFC = $this->commerceRFCFinder($commerceId);
            if ($receipt->isNotMatchInvoiceRFCWith($commerceRFC)) {
                throw new ReceiptInvoiceRFCInvalid();
            }
        }
    }

    private function commerceRFCFinder(string $commerceId): string
    {
        $commerce = $this->queryBus->ask(new CommerceQuery($commerceId));
        return $commerce->data['rfc'];
    }

    private function ensureFileOrNote(Receipt $receipt): void
    {
        if ($receipt->hasNotNote() && $receipt->hasNotFile()) {
            throw new ReceiptFilesOrNoteInvalid();
        }
    }
}