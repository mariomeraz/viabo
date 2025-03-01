<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ExternalAccountBeneficiaryEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido el beneficiario';
    }
}