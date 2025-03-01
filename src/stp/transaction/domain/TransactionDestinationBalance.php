<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class TransactionDestinationBalance extends StringValueObject
{
    public static function create(float $value, float $amount): static
    {
        return new static(strval($value + $amount));
    }

    public static function fromInternalSpeiIn(string $value): static
    {
        return new static($value);
    }

    public static function fromStp(float $value, float $amount): static
    {
        return self::create($value, $amount);
    }

    public function moneyFormat(): string
    {
        return NumberFormat::money(floatval($this->value));
    }

}