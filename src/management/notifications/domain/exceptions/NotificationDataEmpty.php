<?php declare(strict_types=1);


namespace Viabo\management\notifications\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class NotificationDataEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido los datos de la notificación';
    }
}