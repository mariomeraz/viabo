<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderEmailsEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class FundingOrderEmails extends StringValueObject
{
    public static function create(array $value): self
    {
        self::validate($value);
        $value = implode(',' , $value);
        return new self($value);
    }

    public static function validate(array $value): void
    {
        if (empty($value)) {
            throw new FundingOrderEmailsEmpty();
        }
    }

    public static function empty(): static
    {
        return new static('');
    }
}