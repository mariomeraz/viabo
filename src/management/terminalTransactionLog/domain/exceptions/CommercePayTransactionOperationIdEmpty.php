<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class CommercePayTransactionOperationIdEmpty extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El identificador de la operacion esta vacio';
    }
}
