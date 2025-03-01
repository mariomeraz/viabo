<?php declare(strict_types=1);

namespace Viabo\security\user\application\validate_user_profile;

use Viabo\security\user\domain\services\UserValidator;

final readonly class UserProfileValidator
{
    public function __construct(private UserValidator $validator)
    {
    }

    public function __invoke(string $userId): void
    {
        $this->validator->hasAdminStpProfileId($userId);
    }
}
