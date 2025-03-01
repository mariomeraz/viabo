<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\find;


use Viabo\backoffice\costCenter\domain\CostCenter;
use Viabo\backoffice\costCenter\domain\CostCenterRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CostCentersCriteriaFinder
{
    public function __construct(private CostCenterRepository $repository)
    {
    }

    public function __invoke(array $filters): CostCenterResponse
    {
        $filters = Filters::fromValues($filters);
        $costCenters = $this->repository->searchCriteria(new Criteria($filters));
        return new CostCenterResponse(array_map(function (CostCenter $costCenter) {
            return $costCenter->toArray();
        }, $costCenters));
    }
}