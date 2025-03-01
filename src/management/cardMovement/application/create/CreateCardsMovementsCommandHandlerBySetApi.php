<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCardsMovementsCommandHandlerBySetApi implements CommandHandler
{
    public function __construct(private CardsMovementsCreatorBySetApi $creator)
    {
    }

    public function __invoke(CreateCardsMovementsCommandBySetApi $command): void
    {
        $this->creator->__invoke(
            $command->cards ,
            $command->cardsOperations ,
            $command->startDate ,
            $command->endDate ,
            $command->today
        );
    }
}