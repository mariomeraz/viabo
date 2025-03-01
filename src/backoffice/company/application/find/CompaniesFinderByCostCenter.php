<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\backoffice\company\domain\Company;
use Viabo\backoffice\company\domain\CompanyRepository;

final readonly class CompaniesFinderByCostCenter
{
    public function __construct(private CompanyRepository $repository)
    {
    }

    public function __invoke(string $costCenterId): CompaniesResponse
    {
        $companies = $this->repository->searchAll();
        $companies = array_filter($companies, function (Company $company) use ($costCenterId) {
            return $company->hasCostCenter($costCenterId);
        });

        return new CompaniesResponse(array_map(function (Company $company) {
            return $company->toArray();
        }, $companies));
    }
}