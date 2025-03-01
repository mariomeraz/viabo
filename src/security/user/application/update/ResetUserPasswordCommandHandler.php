<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ResetUserPasswordCommandHandler implements CommandHandler
{
    public function __construct(private UserPasswordUpdater $updater)
    {
    }

    public function __invoke(ResetUserPasswordCommand $command): void
    {
        $this->updater->__invoke(
            $command->userId ,
            $command->currentPassword ,
            $command->newPassword ,
            $command->confirmationPassword
        );
    }
}