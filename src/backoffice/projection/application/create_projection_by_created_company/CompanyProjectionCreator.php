<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\create_projection_by_created_company;


use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\backoffice\projection\domain\events\CompanyProjectionCreatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CompanyProjectionCreator
{
    public function __construct(
        private CompanyProjectionRepository $repository,
        private EventBus                    $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $projection = CompanyProjection::create($company);
        $this->repository->save($projection);

        if ($company['createdByAdminStp']) {
            $this->bus->publish(new CompanyProjectionCreatedDomainEventByAdminStp($company['id'], $company));
        }
    }
}