<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_services_by_register;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;

final readonly class ProjectionServicesUpdaterByRegisterCompany
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $companyId, array $services): void
    {
        $projection = $this->repository->search($companyId);

        if (empty($projection)) {
            return;
        }

        $projection->updateServices($services);
        $this->repository->update($projection);
    }
}