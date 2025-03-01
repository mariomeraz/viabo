<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class TicketsQuery implements Query
{
    public function __construct(
        public mixed $userId ,
        public mixed $userProfileId ,
        public bool  $created ,
        public bool  $assigned
    )
    {
    }
}