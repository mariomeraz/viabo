<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_commissions;



use Viabo\backoffice\projection\domain\CompanyProjectionRepository;

final readonly class ProjectionCommissionsUpdater
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(array $company): void
    {
        $projection = $this->repository->search($company['id']);
        $projection->updateCommissions($company['commissions']);
        $this->repository->update($projection);
    }
}