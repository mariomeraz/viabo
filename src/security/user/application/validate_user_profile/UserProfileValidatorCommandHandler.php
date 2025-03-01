<?php declare(strict_types=1);

namespace Viabo\security\user\application\validate_user_profile;

use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UserProfileValidatorCommandHandler implements CommandHandler
{
    public function __construct(private UserProfileValidator $validator)
    {
    }

    public function __invoke(UserProfileValidatorCommand $command): void
    {
        $this->validator->__invoke($command->userId);
    }
}
