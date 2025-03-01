<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\create_users_by_register;


use Viabo\backoffice\company\domain\events\CompanyCreatedDomainEventByAdminCreatedOnRegisterCompany;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCompanyUserSubscriberByAdminCreatedOnRegisterCompany implements DomainEventSubscriber
{
    public function __construct(private CompanyUserCreatorByRegisterCompany $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyCreatedDomainEventByAdminCreatedOnRegisterCompany::class];
    }

    public function __invoke(CompanyCreatedDomainEventByAdminCreatedOnRegisterCompany $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}