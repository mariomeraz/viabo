<?php declare(strict_types=1);


namespace Viabo\stp\transaction\domain\events;


use Viabo\shared\domain\bus\event\DomainEvent;

final readonly class InternalSpeiInTransactionCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string        $aggregateId,
        private array $body,
        string        $eventId = null,
        string        $occurredOn = null
    )
    {
        parent::__construct($aggregateId, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $eventId,
        string $aggregateId,
        array  $body,
        string $occurredOn
    ): DomainEvent
    {
        return new static($aggregateId, $body, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'spei.in.transaction.created.by.internal.transaction';
    }

    public function toPrimitives(): array
    {
        return $this->body;
    }
}