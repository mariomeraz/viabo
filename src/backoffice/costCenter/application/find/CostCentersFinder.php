<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\find;


use Viabo\backoffice\costCenter\domain\CostCenter;
use Viabo\backoffice\costCenter\domain\CostCenterRepository;

final readonly class CostCentersFinder
{
    public function __construct(private CostCenterRepository $repository)
    {
    }

    public function __invoke(string $businessId): CostCenterResponse
    {
        $costCenters = $this->repository->searchAll($businessId);
        return new CostCenterResponse(array_map(function (CostCenter $costCenter) {
            return $costCenter->toArray();
        }, $costCenters));
    }
}