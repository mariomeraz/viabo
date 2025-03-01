<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionStpId extends StringValueObject
{
    public static function empty(): static
    {
        return new static('0');
    }

    public static function create(mixed $value): static
    {
        $value = empty($value)? '0': $value;
        $value = is_string($value) ? $value : strval($value);
        return new static($value);
    }

    public function update(mixed $value): static
    {
        $value = is_string($value) ? $value : strval($value);
        return new static($value);
    }

    public function isSame(mixed $value): bool
    {
        $value = is_string($value) ? $value : strval($value);
        return $this->value === $value;
    }
}