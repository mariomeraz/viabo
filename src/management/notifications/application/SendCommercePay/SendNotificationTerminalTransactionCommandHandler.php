<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCommercePay;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendNotificationTerminalTransactionCommandHandler implements CommandHandler
{
    public function __construct(private NotificationSender $sender)
    {
    }

    public function __invoke(SendNotificationTerminalTransactionCommand $command): void
    {
        $this->sender->__invoke($command->terminalTransaction);
    }
}