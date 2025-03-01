<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CredentialExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Ya esta registrada las credenciales de comercio';
    }
}