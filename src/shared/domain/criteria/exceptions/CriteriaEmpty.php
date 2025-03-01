<?php declare(strict_types=1);


namespace Viabo\shared\domain\criteria\exceptions;


use Viabo\shared\domain\DomainError;

final class CriteriaEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido ningun filtro';
    }
}