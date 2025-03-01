<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_balance;


use Viabo\backoffice\company\application\find\CompanyResponse;
use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompaniesBalanceFinderByStpAccount
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $stpAccountId): CompanyResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'services', 'operator' => 'CONTAINS', 'value' => $stpAccountId]
        ]);
        $companies = $this->repository->searchCriteria(new Criteria($filters));

        $balanceCompanies = array_sum(array_map(function (CompanyProjection $company) {
            return $company->balance();
        }, $companies));
        return new CompanyResponse(['balance' => $balanceCompanies]);
    }
}