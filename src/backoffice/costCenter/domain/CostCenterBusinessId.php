<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CostCenterBusinessId extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }

    public static function create(string $value): static
    {
        return new static($value);
    }
}