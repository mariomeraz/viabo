<?php declare(strict_types=1);


namespace Viabo\security\user\application\login;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class LoginUserCommandHandler implements CommandHandler
{
    public function __construct(private UserLogin $login)
    {
    }

    public function __invoke(LoginUserCommand $command): void
    {
        $this->login->__invoke($command->username, $command->password);
    }
}