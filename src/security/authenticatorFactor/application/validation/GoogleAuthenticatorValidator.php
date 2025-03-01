<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\validation;


use Viabo\security\authenticatorFactor\domain\services\AuthenticatorFactorFinder;
use Viabo\security\authenticatorFactor\domain\services\ValidateGoogleAuthenticatorCode;

final readonly class GoogleAuthenticatorValidator
{
    public function __construct(
        private AuthenticatorFactorFinder       $finder,
        private ValidateGoogleAuthenticatorCode $validateGoogleAuthenticatorCode
    )
    {
    }

    public function __invoke(string $userId, string $userName, string $code): void
    {
        $filters = [
            ['field' => 'userId.value', 'operator' => '=', 'value' => $userId],
            ['field' => 'provider.value', 'operator' => '=', 'value' => 'GoogleAuthenticator']
        ];
        $authenticator = $this->finder->__invoke($filters);
        $this->validateGoogleAuthenticatorCode->__invoke($code, $authenticator->secret(), $userName);

    }
}