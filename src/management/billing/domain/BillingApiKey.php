<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\management\billing\domain\exceptions\BillingApiKeyEmpty;
use Viabo\shared\domain\valueObjects\StringValueObject;

final class BillingApiKey extends StringValueObject
{
    public static function create(mixed $value): static
    {
        $value = strval($value);
        self::validate($value);
        return new static($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new BillingApiKeyEmpty();
        }
    }
}