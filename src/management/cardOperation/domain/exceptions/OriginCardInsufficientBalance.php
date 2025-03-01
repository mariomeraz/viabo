<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class OriginCardInsufficientBalance extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'La tarjeta no tiene suficiente saldo para las transferencias';
    }
}