<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TicketsQueryHandler implements QueryHandler
{
    public function __construct(private TicketsFinder $finder)
    {
    }

    public function __invoke(TicketsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->userId,
            $query->userProfileId,
            $query->assigned,
            $query->created
        );
    }
}