<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CommissionsCreatedByUserEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido el usuario que registra la comision';
    }
}