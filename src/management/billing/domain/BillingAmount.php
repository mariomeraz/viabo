<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class BillingAmount extends StringValueObject
{
    public static function create(mixed $value): static
    {
        return new static(strval($value));
    }
}