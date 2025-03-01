<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionUrlCEP extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }

    public static function create(mixed $value): static
    {
        return new static($value);
    }

    public function update(string $value): static
    {
        return new static($value);
    }
}