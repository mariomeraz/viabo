<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\delete_projection_by_admin_stp;


use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\events\CompanyProjectionDeletedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyProjectionDeleter
{
    public function __construct(
        private CompanyProjectionRepository $repository,
        private EventBus                    $bus
    )
    {
    }

    public function __invoke(string $companyId): void
    {
        $projection = $this->repository->search($companyId);
        $this->repository->delete($projection);

        $this->bus->publish(new CompanyProjectionDeletedDomainEventByAdminStp($companyId));
    }
}