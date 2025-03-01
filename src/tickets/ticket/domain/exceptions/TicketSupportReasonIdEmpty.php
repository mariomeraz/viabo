<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class TicketSupportReasonIdEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido la causa de soporte';
    }
}