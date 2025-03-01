<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_by_register;


use Viabo\backoffice\company\domain\events\CompanyUpdatedDomainEventByRegister;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionSubscriberByRegisterCompany implements DomainEventSubscriber
{
    public function __construct(private ProjectionUpdaterByRegisterCompany $updater)
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