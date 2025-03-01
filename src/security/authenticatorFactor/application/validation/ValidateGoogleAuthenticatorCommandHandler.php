<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\validation;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ValidateGoogleAuthenticatorCommandHandler implements CommandHandler
{
    public function __construct(private GoogleAuthenticatorValidator $validator)
    {
    }

    public function __invoke(ValidateGoogleAuthenticatorCommand $command): void
    {
        $this->validator->__invoke($command->userId, $command->userName, $command->code);
    }
}