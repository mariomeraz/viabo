<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_by_user;


use Viabo\backoffice\company\application\find\CompanyResponse;
use Viabo\backoffice\company\domain\exceptions\CompanyUserNotAssociated;
use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyFinderByUser
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $userId, string $businessId, string $profileId): CompanyResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'users', 'operator' => 'CONTAINS', 'value' => $userId],
            ['field' => 'businessId', 'operator' => '=', 'value' => $businessId],
        ]);
        $companies = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($companies)) {
            throw new CompanyUserNotAssociated();
        }

        $company = array_filter($companies, function (CompanyProjection $projection) use ($profileId) {
            return $projection->hasUserProfileOfType($profileId);
        });

        return new CompanyResponse($company[0]->toArrayOld());
    }

}