<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ServiceTypeNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el tipo de servicio para la empresa';
    }
}