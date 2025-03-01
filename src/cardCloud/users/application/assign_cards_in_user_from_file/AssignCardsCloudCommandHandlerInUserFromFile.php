<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\assign_cards_in_user_from_file;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AssignCardsCloudCommandHandlerInUserFromFile implements CommandHandler
{
    public function __construct(private CardsCloudAssignerFromFile $assigner)
    {
    }

    public function __invoke(AssignCardsCloudCommandInUserFromFile $command): void
    {
        $this->assigner->__invoke(
            $command->businessId,
            $command->userId,
            $command->data['cards'],
            $command->data['user'],
            $command->data['isPending']
        );
    }
}