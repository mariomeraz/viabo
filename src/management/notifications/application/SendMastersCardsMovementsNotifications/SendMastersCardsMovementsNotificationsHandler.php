<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendMastersCardsMovementsNotifications;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendMastersCardsMovementsNotificationsHandler implements CommandHandler
{
    public function __construct(private SendMastersCardsMovements $sender)
    {
    }

    public function __invoke(SendMastersCardsMovementsNotifications $command): void
    {
        $this->sender->__invoke($command->cards);
    }
}