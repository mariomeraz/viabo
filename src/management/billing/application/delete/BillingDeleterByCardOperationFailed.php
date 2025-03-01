<?php declare(strict_types=1);


namespace Viabo\management\billing\application\delete;


use Viabo\management\billing\domain\BillingId;
use Viabo\management\cardOperation\domain\events\OperationFailedDomainEvent;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class BillingDeleterByCardOperationFailed implements DomainEventSubscriber
{
    public function __construct(private BillingDeleter $deleter)
    {
    }

    public static function subscribedTo(): array
    {
        return [OperationFailedDomainEvent::class];
    }

    public function __invoke(OperationFailedDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $billingId = new BillingId($data['billingId']);

        $this->deleter->__invoke($billingId);
    }
}