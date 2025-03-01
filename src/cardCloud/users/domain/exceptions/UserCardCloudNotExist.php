<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserCardCloudNotExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No existe el usuario de la tarjeta';
    }
}