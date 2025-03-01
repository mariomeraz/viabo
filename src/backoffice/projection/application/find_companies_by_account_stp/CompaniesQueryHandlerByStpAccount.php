<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_by_account_stp;


use Viabo\backoffice\projection\application\find_company_by_criteria\CompanyProjectionCriteriaFinder;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompaniesQueryHandlerByStpAccount implements QueryHandler
{
    public function __construct(private CompanyProjectionCriteriaFinder $finder)
    {
    }

    public function __invoke(CompaniesQueryByStpAccount $query): Response
    {
        $filters = [
            ['field' => 'services', 'operator' => 'CONTAINS', 'value' => $query->stpAccountId]
        ];
        return $this->finder->__invoke($filters);
    }
}