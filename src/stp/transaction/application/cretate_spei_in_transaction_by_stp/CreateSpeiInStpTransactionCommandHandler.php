<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\cretate_spei_in_transaction_by_stp;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateSpeiInStpTransactionCommandHandler implements CommandHandler
{
    public function __construct(private SpeiInTransactionCreatorByStp $recorder)
    {
    }

    public function __invoke(CreateSpeiInStpTransactionCommand $command): void
    {
        $this->recorder->__invoke(
            $command->company,
            $command->date,
            $command->stpAccountsDisable
        );
    }
}