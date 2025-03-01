<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\add_companies_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionCreatedDomainEventByAdminStp;
use Viabo\backoffice\projection\domain\events\CompanyProjectionUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateCostCenterCompaniesOnCompanyCreatedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CostCenterCompaniesUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [
            CompanyProjectionCreatedDomainEventByAdminStp::class,
            CompanyProjectionUpdatedDomainEventByAdminStp::class
        ];
    }

    public function __invoke(
        CompanyProjectionCreatedDomainEventByAdminStp|
        CompanyProjectionUpdatedDomainEventByAdminStp $event
    ): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}