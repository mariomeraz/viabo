<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ValidateUserNewCommandHandler implements CommandHandler
{
    public function __construct(private UserNewValidator $validator)
    {
    }

    public function __invoke(ValidateUserNewCommand $command): void
    {
        $this->validator->__invoke($command->userName, $command->userEmail);
    }
}