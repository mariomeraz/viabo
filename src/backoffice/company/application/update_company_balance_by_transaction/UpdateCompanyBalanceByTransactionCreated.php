<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_balance_by_transaction;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\stp\transaction\domain\events\StpTransactionCreatedDomainEvent;

final readonly class UpdateCompanyBalanceByTransactionCreated implements DomainEventSubscriber
{
    public function __construct(private CompanyBalanceUpdaterByStpTransactionCreated $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [StpTransactionCreatedDomainEvent::class];
    }

    public function __invoke(StpTransactionCreatedDomainEvent $event): void
    {
        $transaction = $event->toPrimitives();
        $this->updater->__invoke($transaction);
    }
}