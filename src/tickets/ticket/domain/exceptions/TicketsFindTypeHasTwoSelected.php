<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class TicketsFindTypeHasTwoSelected extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Debes definir solo una opcion de busqueda ya sea creadas o asignadas';
    }
}