<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCostCenterCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $businessId,
        public string $costCenterId,
        public string $name,
        public array $assignedUsers
    )
    {
    }
}