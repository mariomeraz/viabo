<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_subaccount_card_cloud_by_company;


use Viabo\backoffice\projection\application\CompanyProjectionResponse;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\exceptions\CompanyProjectionNotCardCloud;
use Viabo\backoffice\projection\domain\exceptions\CompanyProjectionNotExist;

final readonly class CardCloudSubAccountFinderByCompany
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $companyId): CompanyProjectionResponse
    {
        $company = $this->repository->search($companyId);

        if (empty($company)) {
            throw new CompanyProjectionNotExist();
        }

        $cardCloudSubAccount = $company->cardCloudSubAccount();

        if (empty($cardCloudSubAccount)) {
            throw new CompanyProjectionNotCardCloud();
        }

        return new CompanyProjectionResponse(['subAccount' => $cardCloudSubAccount]);
    }
}