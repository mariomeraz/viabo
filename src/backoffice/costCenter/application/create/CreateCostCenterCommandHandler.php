<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCostCenterCommandHandler implements CommandHandler
{
    public function __construct(private CostCenterCreator $creator)
    {
    }

    public function __invoke(CreateCostCenterCommand $command): void
    {
        $this->creator->__invoke(
            $command->userId,
            $command->businessId,
            $command->costCenterId,
            $command->name,
            $command->assignedUsers
        );
    }
}