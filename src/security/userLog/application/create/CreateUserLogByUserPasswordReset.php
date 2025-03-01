<?php declare(strict_types=1);


namespace Viabo\security\userLog\application\create;


use Viabo\security\user\domain\events\UserPasswordResetDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final class CreateUserLogByUserPasswordReset implements DomainEventSubscriber
{
    public function __construct(private UserLogCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserPasswordResetDomainEvent::class];
    }

    public function __invoke(UserPasswordResetDomainEvent $event): void
    {
        $userId = $event->aggregateId();
        $data = $event->toPrimitives();
        $type = $event->eventName();

        $this->creator->__invoke($userId , $type , $data);
    }
}