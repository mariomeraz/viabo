<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class AuthenticatorFactorExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Ya esta habilitado el autenticador de google';
    }
}