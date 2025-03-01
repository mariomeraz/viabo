<?php declare(strict_types=1);

namespace Viabo\security\user\application\validate_user_profile;

use Viabo\shared\domain\bus\command\Command;

final readonly class UserProfileValidatorCommand implements Command
{
    public function __construct(public string $userId)
    {
    }
}
