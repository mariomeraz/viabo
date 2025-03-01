<?php declare(strict_types=1);


namespace Viabo\security\user\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserNameEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 406;
    }

    public function errorMessage(): string
    {
        return 'El nombre del usuario no esta definido';
    }
}