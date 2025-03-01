<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionBusinessId extends StringValueObject
{
    public static function create(string $value): static
    {
        return new static($value);
    }
}