<?php declare(strict_types=1);


namespace Viabo\security\user\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserEmailExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El email ya esta registrado con otro usuario';
    }
}