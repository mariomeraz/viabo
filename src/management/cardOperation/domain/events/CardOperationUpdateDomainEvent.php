<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain\events;


use Viabo\shared\domain\bus\event\DomainEvent;

final readonly class CardOperationUpdateDomainEvent extends DomainEvent
{
    public function __construct(
        string          $aggregateId ,
        private array   $body ,
        private ?string $emails = null ,
        string          $eventId = null ,
        string          $occurredOn = null
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
        return 'update.operation.transaction.reverse.to.card';
    }

    public function toPrimitives(): array
    {
        return $this->body;
    }

    public function emails(): ?string
    {
        return $this->emails;
    }
}