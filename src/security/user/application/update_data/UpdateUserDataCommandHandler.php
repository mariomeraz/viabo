<?php declare(strict_types=1);

namespace Viabo\security\user\application\update_data;

use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateUserDataCommandHandler implements CommandHandler
{
    public function __construct(private UserDataUpdater $updater)
    {
    }
    public function __invoke(UpdateUserDataCommand $command):void
    {
        $this->updater->__invoke(
            $command->userId,
            $command->name,
            $command->lastName,
            $command->email,
            $command->phone
        );
    }
}
