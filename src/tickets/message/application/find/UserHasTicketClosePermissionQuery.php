<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class UserHasTicketClosePermissionQuery implements Query
{
    public function __construct(public string $userId , public string $ticketId)
    {
    }


}