<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\authenticatorFactor\google;


use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;

final readonly class GoogleAuthenticator implements TwoFactorInterface
{

    public function __construct(private string $username, private string $googleAuthenticatorSecret)
    {
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return null !== $this->googleAuthenticatorSecret;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->username;
    }

    public function getGoogleAuthenticatorSecret(): string|null
    {
        return $this->googleAuthenticatorSecret;
    }

}