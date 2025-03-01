<?php declare(strict_types=1);


namespace Viabo\tickets\message\domain\events;


use Viabo\shared\domain\bus\event\DomainEvent;

final readonly class MessageCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string        $aggregateId ,
        private array $body ,
        string        $eventId = null ,
        string        $occurredOn = null
    )
    {
        parent::__construct($aggregateId , $eventId , $occurredOn);
    }

    public static function fromPrimitives(
        string $eventId ,
        string $aggregateId ,
        array  $body ,
        string $occurredOn
    ): DomainEvent
    {
        return new static($aggregateId , $body , $eventId , $occurredOn);
    }

    public static function eventName(): string
    {
        return 'created.message';
    }

    public function toPrimitives(): array
    {
        return $this->body;
    }
}