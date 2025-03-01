<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain\exceptions;


use Viabo\shared\domain\DomainError;

final class ReceiptFilesOrNoteInvalid extends DomainError
{
    public function errorCode(): int
    {
        return 400;
    }

    public function errorMessage(): string
    {
        return 'No tiene una nota o archivo (imagen o pdf) para la comprobacion';
    }
}