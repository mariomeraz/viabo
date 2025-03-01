<?php declare(strict_types=1);


namespace Viabo\shared\domain\uploadFile;


use Viabo\shared\domain\DomainError;

final class FileFormatNotAllowed extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'Formato de archivo no permitido';
    }
}