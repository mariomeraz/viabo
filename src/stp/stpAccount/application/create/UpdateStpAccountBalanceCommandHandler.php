<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateStpAccountBalanceCommandHandler implements CommandHandler
{
    public function __construct(private BalanceStpAccountUpdater $updater)
    {
    }

    public function __invoke(UpdateStpAccountBalanceCommand $command): void
    {
        $this->updater->__invoke($command->company, $command->stpAccountsDisable);
    }
}