<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\shared\domain\valueObjects\DecimalValueObject;
use Viabo\stp\transaction\domain\exceptions\TransactionAmountEmpty;

final class TransactionAmount extends DecimalValueObject
{
    public static function create(float|string $value): self
    {
        $value = is_string($value) ? floatval($value) : $value;
        self::validate($value);
        return new self($value);
    }

    public static function validate(float $value): void
    {
        if (empty($value)) {
            throw new TransactionAmountEmpty();
        }
    }

    public function moneyFormat(): string
    {
        return NumberFormat::money($this->value);
    }
}