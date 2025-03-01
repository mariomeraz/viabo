<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\create_commission_transaction_by_internal_transaction;


use Viabo\backoffice\company\domain\events\CompanyBalanceUpdatedDomainEventByTransactionCreated;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCommissionTransactionByTransactionCreated implements DomainEventSubscriber
{
    public function __construct(private CommissionTransactionCreatorByTransactionCreated $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyBalanceUpdatedDomainEventByTransactionCreated::class];
    }

    public function __invoke(CompanyBalanceUpdatedDomainEventByTransactionCreated $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}