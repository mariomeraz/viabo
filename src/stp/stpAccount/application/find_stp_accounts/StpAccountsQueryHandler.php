<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_accounts;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StpAccountsQueryHandler implements QueryHandler
{
    public function __construct(private StpAccountsFinder $finder)
    {
    }

    public function __invoke(StpAccountsQuery $query): Response
    {
        return $this->finder->__invoke($query->stpAccountsDisable);
    }
}