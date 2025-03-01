<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\application\events;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\tickets\ticket\domain\events\TicketStatusUpdatedDomainEvent;

final readonly class TicketAdditionalDataFinderByTicketClosed implements DomainEventSubscriber
{
    public function __construct(private ApplicantDataFinder $finder)
    {
    }

    public static function subscribedTo(): array
    {
        return [TicketStatusUpdatedDomainEvent::class];
    }

    public function __invoke(TicketStatusUpdatedDomainEvent $event): void
    {
        $ticket = $event->toPrimitives();
        $ticketResolved = '3';

        if ($ticket['statusId'] === $ticketResolved) {
            $this->finder->__invoke($ticket);
        }
    }
}