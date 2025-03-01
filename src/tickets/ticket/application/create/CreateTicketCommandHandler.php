<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateTicketCommandHandler implements CommandHandler
{
    public function __construct(private TicketCreator $creator)
    {
    }

    public function __invoke(CreateTicketCommand $command): void
    {
        $this->creator->__invoke(
            $command->userId ,
            $command->userProfileId,
            $command->ticketId ,
            $command->supportReasonId ,
            $command->supportReasonAssignedProfileId ,
            $command->description
        );
    }
}