<?php declare(strict_types=1);


namespace Viabo\security\session\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SessionLastQueryHandler implements QueryHandler
{
    public function __construct(private SessionLastFinder $finder)
    {
    }

    public function __invoke(SessionLastQuery $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}