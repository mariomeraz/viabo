<?php declare(strict_types=1);


namespace Viabo\management\credential\infrastructure\doctrine;


use Viabo\management\shared\domain\credential\CardCredentialClientKey;
use Viabo\shared\infrastructure\persistence\UuidType;

final class CardClientKeyType extends UuidType
{
    protected function typeClassName(): string
    {
        return CardCredentialClientKey::class;
    }
}