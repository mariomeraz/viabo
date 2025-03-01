<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class SupportReasonExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Ya esta registrado la causa del soporte';
    }
}