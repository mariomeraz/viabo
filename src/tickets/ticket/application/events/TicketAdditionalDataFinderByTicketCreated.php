<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\events;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\tickets\ticket\domain\events\TicketCreatedDomainEvent;

final readonly class TicketAdditionalDataFinderByTicketCreated implements DomainEventSubscriber
{
    public function __construct(private TicketAdditionalDataFinder $finder)
    {
    }

    public static function subscribedTo(): array
    {
        return [TicketCreatedDomainEvent::class];
    }

    public function __invoke(TicketCreatedDomainEvent $event): void
    {
        $ticket = $event->toPrimitives();
        $this->finder->__invoke($ticket);
    }
}