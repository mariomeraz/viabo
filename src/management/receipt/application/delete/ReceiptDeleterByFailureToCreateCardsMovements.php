<?php declare(strict_types=1);


namespace Viabo\management\receipt\application\delete;


use Viabo\management\cardMovement\domain\events\FailureToCreateCardsMovementsDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class ReceiptDeleterByFailureToCreateCardsMovements implements DomainEventSubscriber
{
    public function __construct(private ReceiptDeleter $deleter)
    {
    }

    public static function subscribedTo(): array
    {
        return [FailureToCreateCardsMovementsDomainEvent::class];
    }

    public function __invoke(FailureToCreateCardsMovementsDomainEvent $event): void
    {
        $receiptId = $event->aggregateId();
        $this->deleter->__invoke($receiptId);
    }
}