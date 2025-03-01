<?php declare(strict_types=1);


namespace Viabo\backoffice\logs\application\create;


use Viabo\backoffice\costCenter\domain\events\CostCenterCreatedDomainEvent;
use Viabo\backoffice\costCenter\domain\events\CostCenterUpdatedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateLogByCostCenter implements DomainEventSubscriber
{

    public function __construct(private LogCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CostCenterCreatedDomainEvent::class, CostCenterUpdatedDomainEvent::class];
    }

    public function __invoke(CostCenterCreatedDomainEvent|CostCenterUpdatedDomainEvent $event): void
    {
        $aggregateId = $event->aggregateId();
        $data = $event->toPrimitives();
        $type = $event->eventName();

        $this->creator->__invoke($aggregateId, $type, $data);
    }
}