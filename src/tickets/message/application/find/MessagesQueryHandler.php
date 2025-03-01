<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class MessagesQueryHandler implements QueryHandler
{
    public function __construct(private MessagesFinder $finder)
    {
    }

    public function __invoke(MessagesQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->userId ,
            $query->userProfileId ,
            $query->ticket,
            $query->limit,
            $query->page
        );
    }
}