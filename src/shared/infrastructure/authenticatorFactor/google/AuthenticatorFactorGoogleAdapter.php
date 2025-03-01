<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\authenticatorFactor\google;


use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Viabo\shared\domain\authenticatorFactor\AuthenticatorFactorAdapter;
use Viabo\shared\domain\qr\QRCodeAdapter;
use Viabo\shared\domain\utils\Crypt;

final readonly class AuthenticatorFactorGoogleAdapter implements AuthenticatorFactorAdapter
{
    public function __construct(
        private GoogleAuthenticatorInterface $googleAuthenticator,
        private QRCodeAdapter                $QRCodeAdapter
    )
    {
    }

    public function getQRContent(string $userName): array
    {
        $secret = $this->googleAuthenticator->generateSecret();
        $authenticator = new GoogleAuthenticator($userName, $secret);
        $qr = $this->QRCodeAdapter->generator('google_authenticator', $this->googleAuthenticator->getQRContent($authenticator));
        return ['qr' => $qr, 'secret' => Crypt::encrypt($secret)];
    }

    public function checkCode(string $code, string $secret, string $userName): bool
    {
        $secret = Crypt::decrypt($secret);
        $authenticator = new GoogleAuthenticator($userName, $secret);
        return $this->googleAuthenticator->checkCode($authenticator,$code);
    }
}