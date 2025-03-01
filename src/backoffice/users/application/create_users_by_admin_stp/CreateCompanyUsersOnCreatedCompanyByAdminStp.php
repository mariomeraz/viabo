<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\create_users_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionCreatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCompanyUsersOnCreatedCompanyByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CompanyUsersCreatorByAdminSTP $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyProjectionCreatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyProjectionCreatedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}