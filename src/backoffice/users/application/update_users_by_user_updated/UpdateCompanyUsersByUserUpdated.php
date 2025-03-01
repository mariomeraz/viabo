<?php declare(strict_types=1);

namespace Viabo\backoffice\users\application\update_users_by_user_updated;

use Viabo\security\user\domain\events\UserUpdatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateCompanyUsersByUserUpdated implements DomainEventSubscriber
{
    public function __construct(private CompanyUsersUpdaterByUserUpdated $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserUpdatedDomainEvent::class];
    }
    public function __invoke(UserUpdatedDomainEvent $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}
