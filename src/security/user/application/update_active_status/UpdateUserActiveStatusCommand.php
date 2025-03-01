<?php declare(strict_types=1);

namespace Viabo\security\user\application\update_active_status;

use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateUserActiveStatusCommand implements Command
{
    public function __construct(public string $userId, public string $active)
    {
    }
}
