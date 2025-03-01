<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\create;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\tickets\ticket\domain\services\validateBusinessRules;
use Viabo\tickets\ticket\domain\Ticket;
use Viabo\tickets\ticket\domain\TicketRepository;

final readonly class TicketCreator
{
    public function __construct(
        private TicketRepository      $repository ,
        private validateBusinessRules $validateBusinessRules ,
        private EventBus              $bus
    )
    {
    }

    public function __invoke(
        string $userId ,
        string $userProfileId ,
        string $ticketId ,
        string $supportReasonId ,
        string $supportReasonAssignedProfileId ,
        string $description
    ): void
    {

        $this->validateBusinessRules->__invoke($userId , $userProfileId);

        $ticket = Ticket::create(
            $ticketId ,
            $supportReasonId ,
            $userProfileId ,
            $supportReasonAssignedProfileId ,
            $description ,
            $userId
        );

        $this->repository->save($ticket);

        $this->bus->publish(...$ticket->pullDomainEvents());

    }

}