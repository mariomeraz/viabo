<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\create_card_cloud_service_by_admin_stp;


use Viabo\backoffice\company\domain\events\CompanyUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCardCloudServiceOnCompanyUpdatedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CardCloudServiceCreatorByAdminStp $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyUpdatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyUpdatedDomainEventByAdminStp $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}
