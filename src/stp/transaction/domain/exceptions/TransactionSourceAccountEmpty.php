<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class TransactionSourceAccountEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido la cuenta de origen';
    }
}