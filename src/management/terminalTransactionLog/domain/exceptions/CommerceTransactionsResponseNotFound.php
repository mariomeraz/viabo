<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class CommerceTransactionsResponseNotFound extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "Movimientos de transacciones de la terminal no encontradas";
    }
}
