<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TicketQueryHandler implements QueryHandler
{
    public function __construct(private TicketFinder $finder)
    {
    }

    public function __invoke(TicketQuery $query): Response
    {
        return $this->finder->__invoke($query->ticketId);
    }
}