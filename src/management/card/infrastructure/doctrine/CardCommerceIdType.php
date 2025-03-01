<?php declare(strict_types=1);


namespace Viabo\management\card\infrastructure\doctrine;


use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\shared\infrastructure\persistence\UuidType;

final class CardCommerceIdType extends UuidType
{
    protected function typeClassName(): string
    {
        return CardCommerceId::class;
    }
}