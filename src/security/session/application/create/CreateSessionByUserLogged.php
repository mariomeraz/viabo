<?php declare(strict_types=1);


namespace Viabo\security\session\application\create;


use Viabo\security\user\domain\events\UserLoggedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateSessionByUserLogged implements DomainEventSubscriber
{
    public function __construct(private SessionCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserLoggedDomainEvent::class];
    }

    public function __invoke(UserLoggedDomainEvent $event): void
    {
        $this->creator->__invoke($event->aggregateId(), $event->occurredOn());
    }
}