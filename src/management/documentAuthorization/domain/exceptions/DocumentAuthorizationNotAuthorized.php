<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class DocumentAuthorizationNotAuthorized extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No estas autorizado para validar documentos';
    }
}