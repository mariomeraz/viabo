<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\management\billing\domain\events\CreatePayCashBillingDomainEvent;
use Viabo\management\fundingOrder\domain\FundingOrderReferencePayCash;
use Viabo\management\fundingOrder\domain\FundingOrderStatusId;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class FundingOrderStatusUpdaterByPayCashCreated implements DomainEventSubscriber
{
    public function __construct(private FundingOrderStatusUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CreatePayCashBillingDomainEvent::class];
    }

    public function __invoke(CreatePayCashBillingDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $referencePayCash = FundingOrderReferencePayCash::create($data['reference']);
        $status = new FundingOrderStatusId('10');

        $this->updater->__invoke($referencePayCash , $status);
    }
}