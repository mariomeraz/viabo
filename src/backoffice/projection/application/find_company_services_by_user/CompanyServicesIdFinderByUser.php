<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_services_by_user;


use Viabo\backoffice\company\domain\exceptions\CompanyUserNotAssociated;
use Viabo\backoffice\projection\application\CompanyProjectionResponse;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\exceptions\CompanyProjectionNotCompletedRegistration;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyServicesIdFinderByUser
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $userId, string $profileId, string $businessId): CompanyProjectionResponse
    {
        $adminViabo = '2';
        if ($profileId === $adminViabo) {
            return new CompanyProjectionResponse([]);
        }

        $adminSTP = '5';
        if ($profileId === $adminSTP) {
            return new CompanyProjectionResponse(['4']);
        }

        $companies = $this->searchCompanies($userId, $businessId);
        $this->ensureRegisterCompany($companies);
        $servicesTypesId = $this->servicesTypesId($companies, $profileId);
        return new CompanyProjectionResponse($servicesTypesId);
    }

    public function searchCompanies(string $userId, string $businessId): array
    {
        $filters = Filters::fromValues([
            ['field' => 'users', 'operator' => 'CONTAINS', 'value' => $userId],
            ['field' => 'businessId', 'operator' => '=', 'value' => $businessId],
        ]);
        $companies = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($companies)) {
            throw new CompanyUserNotAssociated();
        }

        return $companies;
    }

    private function servicesTypesId(array $companies, string $profileId): array
    {
        $companies = array_filter($companies, function (CompanyProjection $projection) use ($profileId) {
            return $projection->hasUserProfileOfType($profileId);
        });

        return $this->servicesTypes($companies);
    }

    private function ensureRegisterCompany(array $companies): void
    {
        array_map(function (CompanyProjection $projection) {
            if ($projection->hasNotCompletedRegistration()) {
                throw new CompanyProjectionNotCompletedRegistration();
            }
        }, $companies);
    }

    public function servicesTypes(array $companies): array
    {
        $typeIds = [];
        array_map(function (CompanyProjection $projection) use (&$typeIds) {
            foreach ($projection->services() as $service) {
                if (!in_array($service['type'], $typeIds)) {
                    $typeIds[] = $service['type'];
                }
            }
            return $typeIds;
        }, $companies);
        return $typeIds;
    }
}