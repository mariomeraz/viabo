<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CompanyProjectionNotCompletedRegistration extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esposible ingresar hasta que se termine de registrar la empresa';
    }
}