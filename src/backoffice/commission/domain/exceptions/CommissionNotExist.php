<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CommissionNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe la comision del comercio';
    }
}