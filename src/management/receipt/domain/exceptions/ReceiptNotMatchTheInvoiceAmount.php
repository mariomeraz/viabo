<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ReceiptNotMatchTheInvoiceAmount extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El total de los movimientos no coinciden con el total de la factura ';
    }
}