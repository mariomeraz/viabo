<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_spei_out_transaction;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateSpeiOutTransactionCommandHandler implements CommandHandler
{
    public function __construct(private SpeiOutTransactionCreator $paymentProcessor)
    {
    }

    public function __invoke(CreateSpeiOutTransactionCommand $command): void
    {
        $this->paymentProcessor->__invoke(
            $command->userId,
            $command->businessId,
            $command->originBankAccount,
            $command->destinationsAccounts,
            $command->concept,
            $command->internalTransaction
        );
    }
}