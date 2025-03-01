<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_commissions;


use Viabo\backoffice\commission\domain\events\CommissionSpeiCreatedDomainEventByAdminStp;
use Viabo\backoffice\commission\domain\events\CommissionSpeiUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionCommissions implements DomainEventSubscriber
{
    public function __construct(private ProjectionCommissionsUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [
            CommissionSpeiCreatedDomainEventByAdminStp::class,
            CommissionSpeiUpdatedDomainEventByAdminStp::class
        ];
    }

    public function __invoke(
        CommissionSpeiCreatedDomainEventByAdminStp|
        CommissionSpeiUpdatedDomainEventByAdminStp $event
    ): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}