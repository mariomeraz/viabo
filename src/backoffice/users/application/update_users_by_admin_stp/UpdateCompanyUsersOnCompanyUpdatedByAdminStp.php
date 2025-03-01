<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\update_users_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateCompanyUsersOnCompanyUpdatedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CompanyUsersUpdaterByAdminSTP $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyProjectionUpdatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyProjectionUpdatedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}