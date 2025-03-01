<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CardMovementDate extends DateTimeValueObject
{
    public static function create(mixed $value): static
    {
        $value = strval($value);
        return new static($value);
    }
}