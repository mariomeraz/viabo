<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderUserEmpty;
use Viabo\shared\domain\valueObjects\UuidValueObject;

final class FundingOrderConciliationUser extends UuidValueObject
{
    public static function create(string $value): self
    {
        self::validate($value);
        return new self($value);
    }

    public static function validate(string $value): void
    {
        if (empty($value)) {
            throw new FundingOrderUserEmpty();
        }
    }

    public static function empty(): static
    {
        $user = parent::random();
        $user->value = '';
        return $user;
    }

}