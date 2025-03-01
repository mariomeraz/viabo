<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionSourceEmail extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

}