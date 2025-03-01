<?php declare(strict_types=1);


namespace Viabo\tickets\status\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class StatusNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el tipo de estatus del ticket';
    }

}