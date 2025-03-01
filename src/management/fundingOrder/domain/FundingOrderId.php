<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderIdEmpty;
use Viabo\shared\domain\valueObjects\UuidValueObject;

final class FundingOrderId extends UuidValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderIdEmpty();
        }
    }
}