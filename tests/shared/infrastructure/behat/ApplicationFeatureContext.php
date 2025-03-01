<?php

declare(strict_types=1);

namespace Viabo\Tests\shared\infrastructure\behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Viabo\shared\infrastructure\bus\event\DomainEventJsonDeserializer;
use Viabo\shared\infrastructure\bus\event\inMemory\InMemorySymfonyEventBus;
use Viabo\shared\infrastructure\doctrine\DatabaseConnections;

final class ApplicationFeatureContext implements Context
{
    public function __construct(
        private DatabaseConnections         $connections,
        private InMemorySymfonyEventBus     $bus,
        private DomainEventJsonDeserializer $deserializer
    )
    {
    }

    /** @BeforeScenario */
    public function cleanEnvironment(): void
    {
        $this->connections->clear();
    }

    /**
     * @Given /^I send an event to the event bus:$/
     */
    public function iSendAnEventToTheEventBus(PyStringNode $event): void
    {
        $domainEvent = $this->deserializer->deserialize($event->getRaw());

        $this->bus->publish($domainEvent);
    }
}
