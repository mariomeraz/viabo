<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CardMovementOperationTypeNotAllowed extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El movimento no es un tipo de operacion externa';
    }
}