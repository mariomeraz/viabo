<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\events;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\tickets\message\domain\events\MessageAdditionalDataFoundDomainEvent;
use Viabo\tickets\ticket\application\update\TicketStatusUpdater;

final readonly class TicketStatusPendingUpdaterByMessageCreated implements DomainEventSubscriber
{
    public function __construct(private TicketStatusUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [MessageAdditionalDataFoundDomainEvent::class];
    }

    public function __invoke(MessageAdditionalDataFoundDomainEvent $event): void
    {
        $message = $event->toPrimitives();
        $statusPending = '2';
        $this->updater->__invoke($message['ticketId'] , $message['createdByUser'] , $statusPending);
    }
}