<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class TerminalConsolidationNotMath extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "La consolidación de las transacciones no coincide.";
    }
}
