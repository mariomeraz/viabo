<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ProspectCompanyEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definida la campañia';
    }
}