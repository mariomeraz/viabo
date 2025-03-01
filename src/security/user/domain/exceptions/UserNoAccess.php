<?php declare(strict_types=1);


namespace Viabo\security\user\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserNoAccess extends DomainError
{
    public function errorCode(): int
    {
        return 403;
    }

    public function errorMessage(): string
    {
        return 'El usuario o password son incorrectos';
    }
}