<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardsMovementsNotifications;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendCardsMovementsNotificationsHandler implements CommandHandler
{
    public function __construct(private SendCardsMovements $sender)
    {
    }

    public function __invoke(SendCardsMovementsNotifications $command): void
    {
        array_map(function (array $card) {
            $this->sender->__invoke($card['ownerName'] , $card['ownerEmail'] , $card['number'] , $card['movements']);
        } , $command->cards);
    }
}