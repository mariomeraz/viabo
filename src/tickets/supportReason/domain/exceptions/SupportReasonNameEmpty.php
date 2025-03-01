<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class SupportReasonNameEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'El nombre de la causa no puede estar vacia';
    }
}