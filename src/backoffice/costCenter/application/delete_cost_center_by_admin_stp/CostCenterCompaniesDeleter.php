<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\delete_cost_center_by_admin_stp;


use Viabo\backoffice\costCenter\domain\CostCenterRepository;

final readonly class CostCenterCompaniesDeleter
{
    public function __construct(private CostCenterRepository $repository)
    {
    }

    public function __invoke(string $companyId): void
    {
        $this->repository->deleteCostCenterCompanies($companyId);
    }
}