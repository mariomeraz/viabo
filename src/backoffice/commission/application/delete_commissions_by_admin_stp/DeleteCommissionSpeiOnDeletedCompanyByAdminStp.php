<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\delete_commissions_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionDeletedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class DeleteCommissionSpeiOnDeletedCompanyByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CommissionSpeiDeleter $deleter)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyProjectionDeletedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyProjectionDeletedDomainEventByAdminStp $event): void
    {
        $this->deleter->__invoke($event->aggregateId());
    }
}