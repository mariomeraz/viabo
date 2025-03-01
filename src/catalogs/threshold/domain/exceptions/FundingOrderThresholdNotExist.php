<?php declare(strict_types=1);


namespace Viabo\catalogs\threshold\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class FundingOrderThresholdNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el umbral de orden de fondeo';
    }
}