<?php declare(strict_types=1);


namespace Viabo\management\documentAuthorization\infrastructure\doctrine;


use Viabo\management\shared\domain\documents\DocumentId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class MDocumentIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return DocumentId::class;
    }
}