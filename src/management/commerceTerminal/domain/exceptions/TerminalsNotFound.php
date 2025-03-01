<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class TerminalsNotFound extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Terminales del comercio no encontradas';
    }
}
