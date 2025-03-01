<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_active;


use Viabo\backoffice\company\domain\events\CompanyActiveUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionActive implements DomainEventSubscriber
{
    public function __construct(private ProjectionActiveUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyActiveUpdatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyActiveUpdatedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}