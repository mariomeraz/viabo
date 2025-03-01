<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ApplicantTicketLimitExceeded extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No puedes tener más de 5 tickets en proceso de resolución.Puedes cancelar o marcar como resuelto alguno de tus tickets en la sección Incidencias y Consultas';
    }
}