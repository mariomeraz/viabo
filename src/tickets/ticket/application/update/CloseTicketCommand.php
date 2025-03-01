<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class CloseTicketCommand implements Command
{
    public function __construct(public string $userId , public int $ticketId)
    {
    }
}