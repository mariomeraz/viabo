<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create_company_by_register;


use Viabo\security\user\domain\events\UserAdminCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCompanySubscriberByAdminCreatedOnRegisterCompany implements DomainEventSubscriber
{
    public function __construct(private CompanyCreatorByAdminCreatedOnRegisterCompany $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserAdminCreatedDomainEvent::class];
    }

    public function __invoke(UserAdminCreatedDomainEvent $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}