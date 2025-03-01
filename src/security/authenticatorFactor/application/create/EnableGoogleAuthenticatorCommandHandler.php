<?php declare(strict_types=1);


namespace Viabo\security\authenticatorFactor\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class EnableGoogleAuthenticatorCommandHandler implements CommandHandler
{
    public function __construct(private GoogleAuthenticatorEnabler $enabler)
    {
    }

    public function __invoke(EnableGoogleAuthenticatorCommand $command): void
    {
        $this->enabler->__invoke(
            $command->userId,
            $command->userName,
            $command->secret,
            $command->code
        );
    }
}