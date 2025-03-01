<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionSourceBalance extends StringValueObject
{
    public static function create(float $value, float $amount): static
    {
        return new static(strval($value - $amount));
    }

    public static function fromInternalSpeiIn(string $value): static
    {
        $value = empty($value) ? '0' : $value;
        return new static($value);
    }

    public static function fromSTP(float $value): static
    {
        return new static(strval($value));
    }

    public function float(): float
    {
        return floatval($this->value);
    }

    public function moneyFormat(): string
    {
        return NumberFormat::money(floatval($this->value));
    }
}