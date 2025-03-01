<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateTerminalTransactionLiquidationStatusCommandHandler implements CommandHandler
{
    public function __construct(public TerminalTransactionLiquidationStatusUpdater $updater)
    {
    }

    public function __invoke(UpdateTerminalTransactionLiquidationStatusCommand $command): void
    {
        $this->updater->__invoke($command->reference, $command->liquidationStatusId);
    }
}