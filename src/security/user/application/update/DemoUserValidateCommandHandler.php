<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DemoUserValidateCommandHandler implements CommandHandler
{
    public function __construct(private DemoUserValidator $validator)
    {
    }

    public function __invoke(DemoUserValidateCommand $command): void
    {
        $userEmail = UserEmail::create($command->userEmail);

        $this->validator->__invoke($userEmail);
    }
}