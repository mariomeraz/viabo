<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\management\billing\domain\exceptions\BillingReferencePayCashEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class BillingReferencePayCash extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new BillingReferencePayCashEmpty();
        }
    }
}