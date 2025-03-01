<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\delete;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DeleteCostCenterCommandHandler implements CommandHandler
{
    public function __construct(private CostCenterDeleter $deleter)
    {
    }

    public function __invoke(DeleteCostCenterCommand $command): void
    {
        $this->deleter->__invoke($command->costCenterId);
    }
}