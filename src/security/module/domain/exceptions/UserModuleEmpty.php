<?php

namespace Viabo\security\module\domain\exceptions;

use Viabo\shared\domain\DomainError;

final class UserModuleEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No tienes acceso a ningún modulo';
    }
}
