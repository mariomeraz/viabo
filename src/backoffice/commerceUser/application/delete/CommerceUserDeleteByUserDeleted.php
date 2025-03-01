<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\application\delete;


use Viabo\backoffice\commerceUser\domain\CommerceUserKey;
use Viabo\security\user\domain\events\UserDeletedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CommerceUserDeleteByUserDeleted implements DomainEventSubscriber
{
    public function __construct(private CommerceUserDeleter $deleter)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserDeletedDomainEvent::class];
    }

    public function __invoke(UserDeletedDomainEvent $event): void
    {
        $userId = CommerceUserKey::create($event->aggregateId());
        $this->deleter->__invoke($userId);
    }
}