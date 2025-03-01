<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\create_services_by_register_company;


use Viabo\backoffice\company\domain\events\CompanyUpdatedDomainEventByRegister;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateServicesSubscribterByCompanyUpdatedOnRegister implements DomainEventSubscriber
{
    public function __construct(private ServicesCreatorByRegisterCompany $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyUpdatedDomainEventByRegister::class];
    }

    public function __invoke(CompanyUpdatedDomainEventByRegister $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}