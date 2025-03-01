<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_by_admin_stp;


use Viabo\backoffice\company\domain\events\CompanyUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionOnCompanyUpdatedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private ProjectionUpdaterByAdminStp $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyUpdatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyUpdatedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}