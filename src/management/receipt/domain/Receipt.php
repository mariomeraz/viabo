<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\management\receipt\domain\events\ReceiptCreatedDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class Receipt extends AggregateRoot
{

    public function __construct(
        private ReceiptId          $id ,
        private ReceiptInvoice     $invoice ,
        private ReceiptAmountTotal $amountTotal ,
        private ReceiptNote        $note ,
        private ReceiptFiles       $files ,
        private ReceiptUserId      $userId ,
        private ReceiptDate        $date
    )
    {
    }

    public static function create(
        string $receiptId ,
        float  $amountTotal ,
        string $note ,
        array  $files ,
        array  $filesData ,
        array  $invoiceData ,
        string $userId
    ): static
    {
        $receipt = new static(
            ReceiptId::create($receiptId) ,
            ReceiptInvoice::create($invoiceData) ,
            ReceiptAmountTotal::create($amountTotal) ,
            new ReceiptNote($note) ,
            ReceiptFiles::fromOrigin($filesData , $files , $receiptId) ,
            new ReceiptUserId($userId) ,
            ReceiptDate::todayDate()
        );

        $receipt->record(new ReceiptCreatedDomainEvent($receipt->id->value() , $receipt->toArray()));
        return $receipt;
    }

    public function userId(): string
    {
        return $this->userId->value();
    }

    public function hasNotTheNecessaryFilesForAnInvoice(): bool
    {
        return !$this->files->hasTheNecessaryFilesForAnInvoice();
    }

    public function hasNotNote(): bool
    {
        return !$this->note->hasNote();
    }

    public function hasNotFile(): bool
    {
        return !$this->files->hasFile();
    }

    public function isNotMatchTheInvoiceAmount(): bool
    {
        return $this->invoice->invoiceAmountTotal() !== $this->amountTotal->value();
    }

    public function originalFiles(): array
    {
        return $this->files->filesOriginal();
    }

    public function directoryPath(): string
    {
        return $this->files->directoryPath();
    }

    public function filesExtensions(): array
    {
        return $this->files->allowedExtensions();
    }

    public function isNotMatchInvoiceRFCWith(string $commerceRFC): bool
    {
        return !$this->invoice->isSameRFC($commerceRFC);
    }

    public function files(): array
    {
        return $this->files->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'invoice' => $this->invoice->value() ,
            'amountTotal' => $this->amountTotal->value() ,
            'note' => $this->note->value() ,
            'files' => $this->files->value() ,
            'userId' => $this->userId->value() ,
            'date' => $this->date->value()
        ];
    }

}