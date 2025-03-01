<?php declare(strict_types=1);


namespace Viabo\security\user\application\create_user_by_admin_stp;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateUserCommandByAdminStp implements Command
{
    public function __construct(
        public string $userId,
        public string $businessId,
        public string $userProfileId,
        public string $name,
        public string $lastname,
        public string $email,
        public string $phone,
    )
    {
    }
}