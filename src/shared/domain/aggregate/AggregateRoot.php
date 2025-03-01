<?php declare(strict_types=1);


namespace Viabo\shared\domain\aggregate;


use Viabo\shared\domain\bus\event\DomainEvent;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }

    final protected function clearDomainEvents(): void
    {
        $this->domainEvents = [];
    }
}
