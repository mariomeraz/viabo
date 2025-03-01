<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ReceiptInvoiceRFCInvalid extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El rfc de la factura no coincide con el del comercio';
    }
}