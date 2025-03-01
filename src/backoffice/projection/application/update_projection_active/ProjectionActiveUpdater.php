<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_active;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;

final readonly class ProjectionActiveUpdater
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(array $company): void
    {
        $projection = $this->repository->search($company['id']);
        $projection->updateActive($company['active']);
        $this->repository->update($projection);
    }
}