<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\add_companies_by_admin_stp;


use Viabo\backoffice\costCenter\domain\CostCenterRepository;
use Viabo\backoffice\costCenter\domain\events\CostCenterUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CostCenterCompaniesUpdater
{
    public function __construct(
        private CostCenterRepository $repository,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $companyId = $company['id'];
        $this->repository->deleteCostCenterCompanies($companyId);
        $company['costCenters'] = array_map(function (string $costCenter) use ($companyId) {
            $costCenter = $this->repository->search($costCenter);
            $costCenter->setCompanies([['companyId' => $companyId]]);
            $this->repository->update($costCenter);
            return $costCenter->toArray();
        }, $company['costCenters']);

        $this->bus->publish(new CostCenterUpdatedDomainEventByAdminStp($companyId, $company));
    }
}