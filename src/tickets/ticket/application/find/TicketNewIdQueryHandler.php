<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TicketNewIdQueryHandler implements QueryHandler
{
    public function __construct(private TicketNewIdFinder $finder)
    {
    }

    public function __invoke(TicketNewIdQuery $query): Response
    {
        return $this->finder->__invoke();
    }
}