<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CostCenterExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Ya existe el centro de costos';
    }
}