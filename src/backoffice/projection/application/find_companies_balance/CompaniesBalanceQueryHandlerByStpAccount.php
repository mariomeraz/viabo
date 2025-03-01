<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_balance;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompaniesBalanceQueryHandlerByStpAccount implements QueryHandler
{
    public function __construct(private CompaniesBalanceFinderByStpAccount $finder)
    {
    }

    public function __invoke(BalanceCompaniesQueryByStpAccount $query): Response
    {
        return $this->finder->__invoke($query->stpAccountId);
    }
}