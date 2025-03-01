<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\domain\services\find_companies_by_admin_profile;

use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompaniesByAdminProfileFinder
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $businessId, string $profileId, string $userId): array
    {
        $filters = [['field' => 'businessId', 'operator' => '=', 'value' => $businessId]];

        $companiesAdminProfileId = '7';
        if ($profileId === $companiesAdminProfileId) {
            $filters[] = ['field' => 'users', 'operator' => 'CONTAINS', 'value' => $userId];
        }

        $filters = Filters::fromValues($filters);
        return $this->repository->searchCriteria(new Criteria($filters));
    }
}
