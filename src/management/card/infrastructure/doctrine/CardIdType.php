<?php declare(strict_types=1);


namespace Viabo\management\card\infrastructure\doctrine;


use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class CardIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CardId::class;
    }
}