<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class AuthenticatorFactorRecoveryKeys extends StringValueObject
{
    public static function empty(): static
    {
        return new static('');
    }
}