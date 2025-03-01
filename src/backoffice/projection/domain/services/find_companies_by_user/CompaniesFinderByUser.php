<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\domain\services\find_companies_by_user;


use Viabo\backoffice\company\domain\exceptions\CompanyUserNotAssociated;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompaniesFinderByUser
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $userId, string $businessId, string $profileId): array
    {
        $filters = Filters::fromValues([
            ['field' => 'users', 'operator' => 'CONTAINS', 'value' => $userId],
            ['field' => 'businessId', 'operator' => '=', 'value' => $businessId],
        ]);
        $companies = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($companies)) {
            throw new CompanyUserNotAssociated();
        }

        return array_filter($companies, function (CompanyProjection $projection) use ($profileId) {
            return $projection->hasUserProfileOfType($profileId);
        });
    }

}