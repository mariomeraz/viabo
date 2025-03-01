<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria\exceptions;


use Viabo\shared\domain\DomainError;

final class FilterOperatorNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Error con el operador del filtro';
    }
}