<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_services;


use Viabo\backoffice\services\domain\events\ServicesCreatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionServices implements DomainEventSubscriber
{
    public function __construct(private ProjectionServicesUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [ServicesCreatedDomainEventByAdminStp::class];
    }

    public function __invoke(ServicesCreatedDomainEventByAdminStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}