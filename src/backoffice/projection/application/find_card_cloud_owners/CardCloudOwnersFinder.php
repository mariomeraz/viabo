<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_card_cloud_owners;


use Viabo\backoffice\projection\application\CompanyProjectionResponse;
use Viabo\backoffice\projection\domain\services\find_company\CompanyProjectionFinder;

final readonly class CardCloudOwnersFinder
{
    public function __construct(private CompanyProjectionFinder $finder)
    {
    }

    public function __invoke(string $companyId): CompanyProjectionResponse
    {
        $company = $this->finder->__invoke($companyId);
        return new CompanyProjectionResponse($company->cardOwners());
    }
}