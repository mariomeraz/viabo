<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CardMovementClientKeyEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definada la clave del cliente';
    }
}