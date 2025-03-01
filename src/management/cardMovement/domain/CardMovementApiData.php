<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardMovementApiData extends StringValueObject
{
    public static function fromAPI(array $value): static
    {
        $value = json_encode($value);
        return new static($value);
    }

    public static function empty(): static
    {
        return new static('');
    }
}