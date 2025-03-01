<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class TerminalTransactionNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe la operacion de la terminal';
    }
}