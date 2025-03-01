<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\tickets\ticket\domain\TicketRepository;

final readonly class TicketNewIdFinder
{
    public function __construct(private TicketRepository $repository)
    {
    }

    public function __invoke(): TicketResponse
    {
        $ticket = $this->repository->searchIdLast();
        if (empty($ticket)) {
            $id = ['id' => '1000000'];
        } else {
            $lastId = $ticket->id();
            $id = ['id' => strval(++$lastId)];
        }

        return new TicketResponse($id);
    }
}