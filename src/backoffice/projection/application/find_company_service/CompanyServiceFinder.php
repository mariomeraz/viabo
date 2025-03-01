<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_service;


use Viabo\backoffice\company\application\find\CompanyResponse;
use Viabo\backoffice\projection\domain\exceptions\CompanyProjectionNotService;
use Viabo\backoffice\projection\domain\services\find_company\CompanyProjectionFinder;

final readonly class CompanyServiceFinder
{
    public function __construct(private CompanyProjectionFinder $finder)
    {
    }

    public function __invoke(string $companyId, string $serviceId): CompanyResponse
    {
        $company = $this->finder->__invoke($companyId);

        if ($company->hasNotServiceType($serviceId)) {
            throw new CompanyProjectionNotService();
        }

        return new CompanyResponse($company->service($serviceId));
    }
}