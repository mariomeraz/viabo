<?php declare(strict_types=1);

namespace Viabo\shared\infrastructure\bus\event;


use Viabo\shared\domain\bus\event\DomainEvent;
use Viabo\shared\domain\Utils;
use RuntimeException;

final class DomainEventJsonDeserializer
{
    public function __construct(private readonly DomainEventMapping $mapping)
    {
    }

    public function deserialize(string $domainEvent): DomainEvent
    {
        $eventData  = Utils::jsonDecode($domainEvent);
        $eventName  = $eventData['data']['type'];
        $eventClass = $this->mapping->for($eventName);

        if (null === $eventClass) {
            throw new RuntimeException("The event <$eventName> doesn't exist or has no subscribers");
        }

        return $eventClass::fromPrimitives(
            $eventData['data']['attributes']['id'],
            $eventData['data']['attributes'],
            $eventData['data']['id'],
            $eventData['data']['occurred_on']
        );
    }
}