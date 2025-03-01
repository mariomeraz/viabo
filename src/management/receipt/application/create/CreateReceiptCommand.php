<?php declare(strict_types=1);


namespace Viabo\management\receipt\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateReceiptCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $receiptId ,
        public string $movements ,
        public string $note ,
        public array  $files ,
        public bool   $isInvoice
    )
    {
    }
}