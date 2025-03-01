<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class FundingOrderAmountEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definida la cantidad a fondear';
    }
}