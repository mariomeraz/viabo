<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\stp\transaction\domain\exceptions\TransactionBankCodeEmpty;

final class TransactionDestinationBankCode extends StringValueObject
{
    public static function create(string|int $value): self
    {
        $value = is_string($value)? $value : strval($value);
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TransactionBankCodeEmpty();
        }
    }

    public static function empty(): static
    {
        return new static('');
    }
}