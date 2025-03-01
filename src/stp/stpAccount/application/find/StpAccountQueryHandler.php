<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StpAccountQueryHandler implements QueryHandler
{
    public function __construct(private StpAccountFinder $finder)
    {
    }

    public function __invoke(StpAccountQuery $query): Response
    {
        return $this->finder->__invoke($query->stpAccountId);
    }
}