<?php declare(strict_types=1);

namespace Viabo\security\user\application\update_active_status;

use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateUserActiveStatusCommandHandler implements CommandHandler
{
    public function __construct(private UserActiveStatusUpdater $updater)
    {
    }
    public function __invoke(UpdateUserActiveStatusCommand $command): void
    {
        $this->updater->__invoke($command->userId,$command->active);
    }
}
