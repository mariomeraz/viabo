<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class EnableGoogleAuthenticatorCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $userName,
        public string $secret,
        public string $code
    )
    {
    }
}