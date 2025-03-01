<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_costsCenter;


use Viabo\backoffice\costCenter\domain\events\CostCenterUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionCostsCenters implements DomainEventSubscriber
{
    public function __construct(private ProjectionCostCentersUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CostCenterUpdatedDomainEventByAdminStp::class];
    }

    public function __invoke(CostCenterUpdatedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}