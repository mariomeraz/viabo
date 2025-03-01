<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\delete_users_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionDeletedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class DeleteCompanyUsersOnCompanyDeletedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CompanyUsersDeleter $deleter)
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