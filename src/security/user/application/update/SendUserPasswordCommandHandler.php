<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\UserPassword;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendUserPasswordCommandHandler implements CommandHandler
{
    public function __construct(private SendUserPassword $send)
    {
    }

    public function __invoke(SendUserPasswordCommand $command): void
    {
        $userId = new UserId($command->userId);
        $password = UserPassword::random();

        $this->send->__invoke($userId, $password, $command->cardNumber, $command->commerce);
    }
}