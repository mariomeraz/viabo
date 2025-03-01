<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\tickets\ticket\domain\exceptions\TicketNotExist;
use Viabo\tickets\ticket\domain\TicketRepository;

final readonly class TicketFinder
{
    public function __construct(private TicketRepository $repository)
    {
    }

    public function __invoke(string $ticketId): TicketResponse
    {
        $ticket = $this->repository->search($ticketId);

        if (empty($ticket)) {
            throw new TicketNotExist();
        }

        return new TicketResponse($ticket->toArray());
    }
}