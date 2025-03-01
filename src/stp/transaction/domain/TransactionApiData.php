<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionApiData extends StringValueObject
{
    public static function empty(): static
    {
        return new static('[]');
    }

    public static function create(array $value): static
    {
        return new static(json_encode($value));
    }

    public function update(array $value): static
    {
        return self::create($value);
    }
}