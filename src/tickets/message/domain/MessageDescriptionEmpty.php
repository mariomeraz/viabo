<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain;


use Viabo\shared\domain\DomainError;

final class MessageDescriptionEmpty extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No esta definido el mensaje';
    }
}