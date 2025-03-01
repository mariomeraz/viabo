<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class TerminalConsolidationCommerceIdEmpty extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return "El identificador del comercio está vacio";
    }
}
