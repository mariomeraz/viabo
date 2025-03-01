<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\create_services_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionCreatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateServicesOnCreatedCompanyByAdminStp implements DomainEventSubscriber
{
    public function __construct(private ServicesCreatorByAdminStp $updater)
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