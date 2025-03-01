<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderConciliationNumberEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderConciliationNumber extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderConciliationNumberEmpty();
        }
    }

    public static function empty(): static
    {
        return new static('');
    }
}