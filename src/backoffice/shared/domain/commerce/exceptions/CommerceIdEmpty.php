<?php declare(strict_types=1);


namespace Viabo\backoffice\shared\domain\commerce\exceptions;


use Viabo\shared\domain\DomainError;

final class CommerceIdEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido el comercio';
    }
}