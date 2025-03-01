<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\bus\query\Response;

final readonly class TicketResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}