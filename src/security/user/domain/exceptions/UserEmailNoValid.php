<?php declare(strict_types=1);


namespace Viabo\security\user\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserEmailNoValid extends DomainError
{
    public function errorCode(): int
    {
        return 406;
    }

    public function errorMessage(): string
    {
        return 'El email ingresado no es valido';
    }
}