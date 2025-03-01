<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_by_admin_stp;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\events\CompanyProjectionUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class ProjectionUpdaterByAdminStp
{
    public function __construct(
        private CompanyProjectionRepository $repository,
        private EventBus                    $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $projection = $this->repository->search($company['id']);
        $projection->updateByAdminStp(
            $company['fiscalName'],
            $company['tradeName'],
            $company['updatedByUser'],
            $company['updateDate']
        );
        $this->repository->update($projection);

        $this->bus->publish(new CompanyProjectionUpdatedDomainEventByAdminStp($company['id'], $company));
    }
}
