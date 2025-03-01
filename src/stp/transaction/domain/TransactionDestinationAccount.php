<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\stp\transaction\domain\exceptions\TransactionDestinationAccountEmpty;

final class TransactionDestinationAccount extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new TransactionDestinationAccountEmpty();
        }
    }
}