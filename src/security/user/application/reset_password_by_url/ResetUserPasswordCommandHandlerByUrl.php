<?php declare(strict_types=1);


namespace Viabo\security\user\application\reset_password_by_url;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ResetUserPasswordCommandHandlerByUrl implements CommandHandler
{
    public function __construct(private UserPasswordUpdaterByUrl $updater)
    {
    }

    public function __invoke(ResetUserPasswordCommandByUrl $command): void
    {
        $this->updater->__invoke($command->userId);
    }
}