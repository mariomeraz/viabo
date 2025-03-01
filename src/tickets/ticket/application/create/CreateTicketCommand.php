<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateTicketCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $userProfileId ,
        public string $ticketId ,
        public string $supportReasonId ,
        public string $supportReasonAssignedProfileId ,
        public string $description
    )
    {
    }
}