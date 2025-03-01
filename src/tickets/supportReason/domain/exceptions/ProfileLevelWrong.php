<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ProfileLevelWrong extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No puede el asignado tener un nivel bajo o igual que solicitante';
    }
}