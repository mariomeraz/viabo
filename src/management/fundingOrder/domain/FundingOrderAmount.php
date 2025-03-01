<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderAmountEmpty;
use Viabo\shared\domain\utils\NumberFormat;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderAmount extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderAmountEmpty();
        }
    }

    public function format(): string
    {
        return NumberFormat::money(floatval($this->value));
    }
}