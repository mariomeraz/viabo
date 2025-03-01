<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria\exceptions;


use Viabo\shared\domain\DomainError;

final class FilterValueEmpty extends DomainError
{

    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El valor del filtro esta vacio';
    }
}