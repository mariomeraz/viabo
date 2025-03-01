<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\domain;


use Viabo\security\authenticatorFactor\domain\events\GoogleAuthenticatorEnabledDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class AuthenticatorFactor extends AggregateRoot
{
    public function __construct(
        private AuthenticatorFactorId           $id,
        private AuthenticatorFactorUserId       $userId,
        private AuthenticatorFactorProvider     $provider,
        private AuthenticatorFactorSecretKey    $secretKey,
        private AuthenticatorFactorRecoveryKeys $recoveryKeys,
        private AuthenticatorFactorCreateDate   $createDate
    )
    {
    }

    public static function fromGoogle(string $userId, string $secret): static
    {
        $authenticator = new static(
            AuthenticatorFactorId::random(),
            new AuthenticatorFactorUserId($userId),
            AuthenticatorFactorProvider::google(),
            new AuthenticatorFactorSecretKey($secret),
            AuthenticatorFactorRecoveryKeys::empty(),
            AuthenticatorFactorCreateDate::todayDate()
        );
        $authenticator->record(new GoogleAuthenticatorEnabledDomainEvent(
            $authenticator->id(), $authenticator->toArray()
        ));
        return $authenticator;
    }

    public function id(): string
    {
        return $this->id->value();
    }

    public function secret(): string
    {
        return $this->secretKey->value();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'userId' => $this->userId->value(),
            'provider' => $this->provider->value(),
            'secretKey' => $this->secretKey->value(),
            'recoveryKeys' => $this->recoveryKeys->value(),
            'createDate' => $this->createDate->value()
        ];
    }
}