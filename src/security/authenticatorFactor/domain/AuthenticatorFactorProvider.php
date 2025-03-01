<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class AuthenticatorFactorProvider extends StringValueObject
{
    public static function google(): static
    {
        return new static('GoogleAuthenticator');
    }
}