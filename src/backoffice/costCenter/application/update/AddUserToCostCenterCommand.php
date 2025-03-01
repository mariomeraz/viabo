<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class AddUserToCostCenterCommand implements Command
{
    public function __construct(public string $costCenterId, public string $userId)
    {
    }
}