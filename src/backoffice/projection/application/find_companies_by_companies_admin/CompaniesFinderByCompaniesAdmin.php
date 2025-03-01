<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_by_companies_admin;


use Viabo\backoffice\company\application\find\CompaniesResponse;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\services\find_companies_by_admin_profile\CompaniesByAdminProfileFinder;

final readonly class CompaniesFinderByCompaniesAdmin
{
    public function __construct(private CompaniesByAdminProfileFinder $companiesByAdminProfileFinder)
    {
    }

    public function __invoke(string $userId, string $businessId, string $profileId): CompaniesResponse
    {
        $companies = $this->companiesByAdminProfileFinder->__invoke($businessId, $profileId, $userId);

        $companies = array_values(array_filter($companies, function (CompanyProjection $company) {
            return $company->hasServiceSpei();
        }));

        return new CompaniesResponse(array_map(function (CompanyProjection $company) {
            return $company->toArrayOld();
        }, $companies));
    }
}
