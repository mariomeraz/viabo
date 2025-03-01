<?php declare(strict_types=1);


namespace Viabo\management\card\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class MasterCardNotSupported extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No es posible liquidar el movimiento porque el comercio destino no cuenta con una cuenta maestra compatible';
    }
}