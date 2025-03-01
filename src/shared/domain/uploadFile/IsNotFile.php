<?php declare(strict_types=1);


namespace Viabo\shared\domain\uploadFile;


use Viabo\shared\domain\DomainError;

final class IsNotFile extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No es un archivo';
    }
}