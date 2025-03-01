<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\transactions;


use Viabo\management\billing\domain\events\BillingCreatedDomainEvent;
use Viabo\management\cardOperation\domain\CardOperationBalance;
use Viabo\management\cardOperation\domain\CardOperationOrigin;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CommissionBillingProcessorByBillingCreated implements DomainEventSubscriber
{
    public function __construct(private CommissionBillingProcessor $processor)
    {
    }

    public static function subscribedTo(): array
    {
        return [BillingCreatedDomainEvent::class];
    }

    public function __invoke(BillingCreatedDomainEvent $event): void
    {
        $data = $event->toPrimitives();
        $originCardMain = new CardOperationOrigin($data['cardNumber']);
        $balance = new CardOperationBalance($data['commission']);

        $this->processor->__invoke($originCardMain, $balance, $data['id']);
    }
}