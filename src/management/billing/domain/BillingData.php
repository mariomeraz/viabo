<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\management\billing\domain\exceptions\DepositDataEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class BillingData extends StringValueObject
{
    public static function create(?array $value): static
    {
        self::validate($value);
        return new static(json_encode($value));
    }

    public static function validate(?array $value): void
    {
        if (empty($value)) {
            throw new DepositDataEmpty();
        }
    }
}