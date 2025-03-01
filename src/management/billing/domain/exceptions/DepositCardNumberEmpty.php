<?php declare(strict_types=1);


namespace Viabo\management\billing\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class DepositCardNumberEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Api reference empty';

    }
}