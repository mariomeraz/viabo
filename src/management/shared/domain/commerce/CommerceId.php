<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\commerce;


use Viabo\shared\domain\valueObjects\UuidValueObject;

final class CommerceId extends UuidValueObject
{
    public static function create(): self
    {
        return new self(self::random()->value());
    }
}