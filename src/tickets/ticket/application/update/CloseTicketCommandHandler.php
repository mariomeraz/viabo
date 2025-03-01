<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CloseTicketCommandHandler implements CommandHandler
{
    public function __construct(private TicketStatusUpdater $statusUpdater)
    {
    }

    public function __invoke(CloseTicketCommand $command): void
    {
        $ticketResolved = '3';
        $this->statusUpdater->__invoke(
            strval($command->ticketId) ,
            $command->userId ,
            $ticketResolved
        );
    }
}