<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\domain\services\find_companies_by_criteria;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompaniesProjectionFinderByCriteria
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(array $filters): array
    {
        $filters = Filters::fromValues($filters);
        return $this->repository->searchCriteria(new Criteria($filters));
    }
}