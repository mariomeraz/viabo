<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class TerminalIdNotExistInCommerce extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El comercio no tiene la terminal';
    }
}