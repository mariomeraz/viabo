<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\events;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\tickets\message\domain\events\MessageCreatedDomainEvent;

final readonly class MessageAdditionalDataFinderByMessageCreated implements DomainEventSubscriber
{
    public function __construct(private MessageAdditionalDataFinder $finder)
    {
    }

    public static function subscribedTo(): array
    {
        return [MessageCreatedDomainEvent::class];
    }

    public function __invoke(MessageCreatedDomainEvent $event): void
    {
        $message = $event->toPrimitives();
        $this->finder->__invoke($message);
    }
}