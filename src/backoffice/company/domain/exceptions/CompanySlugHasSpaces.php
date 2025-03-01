<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class CompanySlugHasSpaces extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El slug no debe tener espacios';
    }
}