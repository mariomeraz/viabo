<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\events;


use Viabo\backoffice\company\domain\events\CompanyBalanceUpdatedDomainEventByStpTransactionCreated;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateStpTransactionByInternalTransactionCreated implements DomainEventSubscriber
{
    public function __construct(private StpTransactionCreatorByInternalTransaction $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyBalanceUpdatedDomainEventByStpTransactionCreated::class];
    }

    public function __invoke(CompanyBalanceUpdatedDomainEventByStpTransactionCreated $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}