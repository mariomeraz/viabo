<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCostCenterCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $costCenterId,
        public string $name,
        public array  $assignedUsers
    )
    {
    }
}