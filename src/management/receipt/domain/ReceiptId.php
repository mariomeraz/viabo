<?php declare(strict_types=1);


namespace Viabo\management\receipt\domain;


use Viabo\shared\domain\valueObjects\UuidValueObject;

final class ReceiptId extends UuidValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}