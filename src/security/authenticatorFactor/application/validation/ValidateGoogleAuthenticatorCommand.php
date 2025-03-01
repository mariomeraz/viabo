<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\validation;


use Viabo\shared\domain\bus\command\Command;

final readonly class ValidateGoogleAuthenticatorCommand implements Command
{
    public function __construct(public string $userId, public string $userName, public string $code)
    {
    }
}