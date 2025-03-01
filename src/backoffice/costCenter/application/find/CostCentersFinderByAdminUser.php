<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\find;


use Viabo\backoffice\costCenter\domain\CostCenter;
use Viabo\backoffice\costCenter\domain\CostCenterRepository;

final readonly class CostCentersFinderByAdminUser
{
    public function __construct(private CostCenterRepository $repository)
    {
    }

    public function __invoke(string $userId): CostCenterResponse
    {
        $costsCenter = $this->repository->searchByAdminUser($userId);
        return new CostCenterResponse(array_map(function (CostCenter $costCenter){
            return $costCenter->toArray();
        },$costsCenter));
    }
}