<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\update;


use Viabo\shared\domain\bus\event\EventBus;
use Viabo\tickets\ticket\domain\exceptions\TicketNotExist;
use Viabo\tickets\ticket\domain\TicketRepository;

final readonly class TicketStatusUpdater
{
    public function __construct(
        private TicketRepository $repository,
        private EventBus $bus
    )
    {
    }

    public function __invoke(string $ticketId , string $userId , string $newStatus): void
    {
        $ticket = $this->repository->search($ticketId);

        if (empty($ticket)) {
            throw new TicketNotExist();
        }

        if ($ticket->isStatusDifferent($newStatus)) {
            $ticket->updateStatus($newStatus);
            $this->repository->update($ticket);

            $this->bus->publish(...$ticket->pullDomainEvents());
        }

    }
}