<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class ResetUserPasswordCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $currentPassword ,
        public string $newPassword ,
        public string $confirmationPassword
    )
    {
    }
}