<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionActive extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }

    public static function disable(): static
    {
        return new static('0');
    }

    public function value(): string
    {
        return empty($this->value) ? '0' : $this->value;
    }
}