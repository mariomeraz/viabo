<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\delete;


use Viabo\shared\domain\bus\command\Command;

final readonly class DeleteCostCenterCommand implements Command
{
    public function __construct(public string $costCenterId)
    {
    }
}