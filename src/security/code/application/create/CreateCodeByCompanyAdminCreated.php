<?php declare(strict_types=1);


namespace Viabo\security\code\application\create;


use Viabo\security\user\domain\events\UserAdminCreatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCodeByCompanyAdminCreated implements DomainEventSubscriber
{
    public function __construct(private CodeCreator $creator)
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