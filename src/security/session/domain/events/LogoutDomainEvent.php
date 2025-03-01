<?php declare(strict_types=1);


namespace Viabo\security\session\domain\events;


use Viabo\shared\domain\bus\event\DomainEvent;

final readonly class LogoutDomainEvent extends DomainEvent
{
    public function __construct(
        string $aggregateId ,
        string $occurredOn ,
        string $eventId = null
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
        return new self($aggregateId , $occurredOn , $eventId);
    }

    public static function eventName(): string
    {
        return 'user.session.logout';
    }

    public function toPrimitives(): array
    {
        return [];
    }
}