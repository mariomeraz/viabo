<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\assign_cards_in_company;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AssignCardsCommandHandlerInCompany implements CommandHandler
{
    public function __construct(private CardsCloudAssigner $assigner)
    {
    }

    public function __invoke(AssignCardsCommandInCompany $command): void
    {
        $this->assigner->__invoke($command->businessId, $command->data);
    }
}