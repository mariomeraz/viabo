<?php declare(strict_types=1);

namespace Viabo\security\user\application\update_data;

use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateUserDataCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $lastName,
        public string $email,
        public string $phone,
    ){
    }
}
