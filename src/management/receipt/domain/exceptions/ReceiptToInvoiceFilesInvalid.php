<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ReceiptToInvoiceFilesInvalid extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No tiene los archivos necesarios para el comprobante de una factura';
    }
}