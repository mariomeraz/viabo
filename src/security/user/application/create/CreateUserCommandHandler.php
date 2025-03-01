<?php declare(strict_types=1);


namespace Viabo\security\user\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateUserCommandHandler implements CommandHandler
{
    public function __construct(private UserCreator $creator)
    {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $userProfileId = '4';
        $this->creator->__invoke(
            $command->userId,
            $userProfileId,
            $command->name,
            $command->lastName,
            $command->email,
            $command->phone
        );
    }
}