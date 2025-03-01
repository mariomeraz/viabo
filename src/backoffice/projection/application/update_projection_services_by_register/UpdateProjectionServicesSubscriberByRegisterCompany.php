<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_services_by_register;


use Viabo\backoffice\services\domain\events\ServicesCreatedDomainEventByRegisterCompany;
use Viabo\backoffice\services\domain\events\ServicesUpdateDomainEventByRegisterCompany;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionServicesSubscriberByRegisterCompany implements DomainEventSubscriber
{
    public function __construct(private ProjectionServicesUpdaterByRegisterCompany $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [ServicesCreatedDomainEventByRegisterCompany::class, ServicesUpdateDomainEventByRegisterCompany::class];
    }

    public function __invoke(ServicesCreatedDomainEventByRegisterCompany
                             |ServicesUpdateDomainEventByRegisterCompany $event): void
    {
        $companyId = $event->aggregateId();
        $services = $event->toPrimitives();
        $this->updater->__invoke($companyId, $services);
    }
}