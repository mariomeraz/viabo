<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\find;


use Viabo\shared\domain\authenticatorFactor\AuthenticatorFactorAdapter;

final readonly class GoogleAuthenticatorQRFinder
{
    public function __construct(private AuthenticatorFactorAdapter $adapter)
    {
    }

    public function __invoke(string $userName): GoogleAuthenticatorQRResponse
    {
        $qr = $this->adapter->getQRContent($userName);
        return new GoogleAuthenticatorQRResponse($qr);
    }
}