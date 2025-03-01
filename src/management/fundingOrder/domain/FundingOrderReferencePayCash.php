<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderReferencePayCashEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderReferencePayCash extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderReferencePayCashEmpty();
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public function update(string $value): static
    {
        return new static($value);
    }

    public function base64Encode(): string
    {
        return base64_encode($this->value);
    }
}