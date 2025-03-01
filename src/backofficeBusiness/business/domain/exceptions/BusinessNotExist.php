<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class BusinessNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el negocio';
    }
}