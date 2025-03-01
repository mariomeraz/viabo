<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class TerminalTypeIdEmpty extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El identificador del tipo de terminal esta vacío';
    }
}
