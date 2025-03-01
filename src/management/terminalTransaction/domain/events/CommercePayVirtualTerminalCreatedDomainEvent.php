<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain\events;

use Viabo\shared\domain\bus\event\DomainEvent;

final readonly class CommercePayVirtualTerminalCreatedDomainEvent extends DomainEvent
{
    public function __construct(
        string        $aggregateId ,
        private array $body ,
        private array $transactionData ,
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
        return new self($aggregateId , $body , [] , $eventId , $occurredOn);
    }

    public static function eventName(): string
    {
        return 'created.commerce.virtual.terminal.pay';
    }

    public function toPrimitives(): array
    {
        return $this->body;
    }

    public function transactionData(): array
    {
        return $this->transactionData;
    }

}
