<?php declare(strict_types=1);


namespace Viabo\management\credential\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CardIdEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definida el Id de la tarjeta';
    }
}