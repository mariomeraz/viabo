<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CredentialNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El comercio no tiene credenciales';
    }
}