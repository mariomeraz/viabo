<?php declare(strict_types=1);


namespace Viabo\management\paymentProcessor\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class PaymentProcessorNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El procesador de pago no existe';
    }
}