<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CommerceUserNotSameCommerce extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El usuario no pertenece al mismo comercio';
    }
}