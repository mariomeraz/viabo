<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;
use Viabo\stp\externalAccount\domain\exceptions\ExternalAccountBeneficiaryEmpty;

final class ExternalAccountBeneficiary extends StringValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new ExternalAccountBeneficiaryEmpty();
        }
    }
}