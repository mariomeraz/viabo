<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCostCenterCommandHandler implements CommandHandler
{
    public function __construct(private CostCenterUpdater $updater)
    {
    }

    public function __invoke(UpdateCostCenterCommand $command): void
    {
        $this->updater->__invoke(
            $command->userId,
            $command->costCenterId,
            $command->name,
            $command->assignedUsers
        );
    }
}