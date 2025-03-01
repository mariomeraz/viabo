<?php declare(strict_types=1);


namespace Viabo\management\receipt\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateReceiptCommandHandler implements CommandHandler
{
    public function __construct(private ReceiptCreator $creator)
    {
    }

    public function __invoke(CreateReceiptCommand $command): void
    {
        $this->creator->__invoke(
            $command->receiptId ,
            $command->userId ,
            $command->movements ,
            $command->note ,
            $command->files ,
            $command->isInvoice
        );
    }
}