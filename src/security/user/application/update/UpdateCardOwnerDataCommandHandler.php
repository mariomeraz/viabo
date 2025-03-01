<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCardOwnerDataCommandHandler implements CommandHandler
{
    public function __construct(private CardOwnerDataUpdater $updater)
    {
    }

    public function __invoke(UpdateCardOwnerDataCommand $command): void
    {
        $this->updater->__invoke(
            $command->ownerId ,
            $command->name ,
            $command->lastName ,
            $command->phone
        );
    }
}