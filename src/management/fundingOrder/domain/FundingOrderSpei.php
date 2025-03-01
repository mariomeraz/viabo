<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderSpeiEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderSpei extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderSpeiEmpty();
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

}