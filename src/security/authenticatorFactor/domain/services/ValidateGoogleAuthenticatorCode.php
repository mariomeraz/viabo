<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain\services;


use Viabo\security\authenticatorFactor\domain\exceptions\AuthenticatorFactorCodeIncorrect;
use Viabo\shared\domain\authenticatorFactor\AuthenticatorFactorAdapter;

final readonly class ValidateGoogleAuthenticatorCode
{

    public function __construct(private AuthenticatorFactorAdapter $adapter)
    {
    }

    public function __invoke(string $code, string $secret, string $userName): void
    {
        if (!$this->adapter->checkCode($code, $secret, $userName)) {
            throw new AuthenticatorFactorCodeIncorrect();
        }
    }
}