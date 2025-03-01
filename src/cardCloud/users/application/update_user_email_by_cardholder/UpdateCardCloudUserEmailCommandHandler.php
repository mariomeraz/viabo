<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\update_user_email_by_cardholder;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCardCloudUserEmailCommandHandler implements CommandHandler
{
    public function __construct(private CardCloudUserEmailUpdater $updater)
    {
    }

    public function __invoke(UpdateCardCloudUserEmailCommand $command): void
    {
        $this->updater->__invoke($command->ownerId, $command->email);
    }
}