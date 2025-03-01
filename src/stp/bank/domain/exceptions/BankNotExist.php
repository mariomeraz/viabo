<?php declare(strict_types=1);


namespace Viabo\stp\bank\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class BankNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el banco';
    }
}