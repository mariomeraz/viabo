<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\delete_services_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionDeletedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class DeleteServicesOnCompanyDeletedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private ServicesDeleter $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyProjectionDeletedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyProjectionDeletedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->aggregateId());
    }
}