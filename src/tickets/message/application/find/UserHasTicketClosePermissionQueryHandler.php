<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class UserHasTicketClosePermissionQueryHandler implements QueryHandler
{
    public function __construct(private UserHasTicketClosePermissionFinder $finder)
    {
    }

    public function __invoke(UserHasTicketClosePermissionQuery $query): Response
    {
        return $this->finder->__invoke($query->userId , $query->ticketId);
    }
}