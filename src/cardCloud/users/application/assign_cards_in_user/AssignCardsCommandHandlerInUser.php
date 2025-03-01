<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\application\assign_cards_in_user;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AssignCardsCommandHandlerInUser implements CommandHandler
{
    public function __construct(private CardsAssignerInUser $assigner)
    {
    }

    public function __invoke(AssignCardsCommandInUser $command): void
    {
        $this->assigner->__invoke(
            $command->businessId,
            $command->userId,
            $command->data['cards'],
            $command->data['user']
        );
    }
}