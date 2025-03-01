<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\delete_projection_by_admin_stp;


use Viabo\backoffice\company\domain\events\CompanyDeletedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class DeleteCompanyProjectionOnDeletedCompanyByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CompanyProjectionDeleter $deleter)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyDeletedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyDeletedDomainEventByAdminStp $event): void
    {
        $this->deleter->__invoke($event->aggregateId());
    }
}