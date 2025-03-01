<?php declare(strict_types=1);


namespace Viabo\backoffice\documents\infrastructure\doctrine;


use Viabo\backoffice\shared\domain\documents\DocumentId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class DocumentIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return DocumentId::class;
    }
}