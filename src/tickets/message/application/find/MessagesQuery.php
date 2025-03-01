<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class MessagesQuery implements Query
{
    public function __construct(
        public string $userId ,
        public string $userProfileId ,
        public string $ticket ,
        public int    $limit ,
        public int    $page
    )
    {
    }
}