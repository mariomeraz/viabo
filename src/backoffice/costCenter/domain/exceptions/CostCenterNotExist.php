<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CostCenterNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el centro de costos';
    }
}