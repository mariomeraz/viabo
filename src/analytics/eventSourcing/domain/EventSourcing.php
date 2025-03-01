<?php declare(strict_types=1);


namespace Viabo\analytics\eventSourcing\domain;


final readonly class EventSourcing
{
    public function __construct(
        private EventSourcingId          $id ,
        private EventSourcingType        $type ,
        private EventSourcingAggregateId $aggregateId ,
        private EventSourcingBody        $body ,
        private EventSourcingOccurredOn  $occurredOn
    )
    {
    }
}