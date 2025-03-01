<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class UserCardCloudEmptyBusinessId extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido la unidad de negocio';
    }
}