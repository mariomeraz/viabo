<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserCardCloudExist extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Ya esta asignadas las tarjetas';
    }
}