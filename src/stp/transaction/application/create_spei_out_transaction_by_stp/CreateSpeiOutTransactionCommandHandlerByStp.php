<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_spei_out_transaction_by_stp;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateSpeiOutTransactionCommandHandlerByStp implements CommandHandler
{
    public function __construct(private SpeiOutTransactionCreatorByStp $recorder)
    {
    }

    public function __invoke(CreateSpeiOutTransactionCommandByStp $command): void
    {
        $this->recorder->__invoke($command->company, $command->stpAccountsDisable);
    }
}