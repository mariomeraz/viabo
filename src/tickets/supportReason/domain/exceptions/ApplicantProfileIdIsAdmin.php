<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ApplicantProfileIdIsAdmin extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El solicitante no puede ser administrador';
    }

}