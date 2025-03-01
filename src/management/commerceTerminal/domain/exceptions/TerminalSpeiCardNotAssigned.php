<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class TerminalSpeiCardNotAssigned extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'La Tarjeta maestra no se encuentra asignada a la terminal';
    }
}
