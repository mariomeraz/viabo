<?php declare(strict_types=1);


namespace Viabo\security\user\application\create;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\user\domain\UserName;
use Viabo\security\user\domain\UserPhone;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCommerceDemoUserCommandHandler implements CommandHandler
{
    public function __construct(private CommerceDemoUserCreator $creator)
    {
    }

    public function __invoke(CreateCommerceDemoUserCommand $command): void
    {
        $name = UserName::create($command->name);
        $email = UserEmail::create($command->email);
        $phone = new UserPhone($command->phone);

        $this->creator->__invoke($name , $email , $phone);
    }
}