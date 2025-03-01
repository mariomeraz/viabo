<?php declare(strict_types=1);


namespace Viabo\tickets\status\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StatusQueryHandler implements QueryHandler
{
    public function __construct(private StatusFinder $finder)
    {
    }

    public function __invoke(StatusQuery $query): Response
    {
        return $this->finder->__invoke($query->statusId);
    }
}