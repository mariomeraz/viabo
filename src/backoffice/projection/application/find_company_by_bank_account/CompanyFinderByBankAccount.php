<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_by_bank_account;


use Viabo\backoffice\company\application\find\CompanyResponse;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\exceptions\CompanyBankAccountEmpty;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyFinderByBankAccount
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $bankAccount, string $businessId): CompanyResponse
    {
        $filters = [
            ['field' => 'services', 'operator' => 'CONTAINS', 'value' => $bankAccount]
        ];

        if(!empty($businessId)){
            $filters[] = ['field' => 'businessId', 'operator' => '=', 'value' => $businessId];
        }

        $filters = Filters::fromValues($filters);
        $companies = $this->repository->searchCriteria(new Criteria($filters));

        $company = array_filter($companies,function (CompanyProjection $projection) use ($bankAccount) {
            return $projection->isBankAccount($bankAccount);
        });

        if (empty($company)) {
            throw new CompanyBankAccountEmpty($bankAccount);
        }

        return new CompanyResponse($company[0]->toArrayOld());
    }
}