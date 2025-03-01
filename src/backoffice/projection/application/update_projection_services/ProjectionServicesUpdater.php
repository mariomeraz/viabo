<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_services;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;

final readonly class ProjectionServicesUpdater
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(array $company): void
    {
        $projection = $this->repository->search($company['id']);
        $projection->updateServices($company['services']);
        $this->repository->update($projection);
    }
}
