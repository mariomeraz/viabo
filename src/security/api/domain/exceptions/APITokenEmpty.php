<?php declare(strict_types=1);


namespace Viabo\security\api\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class APITokenEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido el token';
    }
}