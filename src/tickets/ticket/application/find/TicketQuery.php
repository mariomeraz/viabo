<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class TicketQuery implements Query
{
    public function __construct(public string $ticketId)
    {
    }
}