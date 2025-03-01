<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CredentialPaymentProcessorEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Debe ingresar clave de al menos un procesador de pago (mastercard o carnet)';
    }
}