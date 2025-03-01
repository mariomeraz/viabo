<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_balance_by_stp;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\stp\transaction\domain\events\TransactionCreatedDomainEventByStp;

final class UpdateCompanyBalanceOnTransactionCreatedByStp implements DomainEventSubscriber
{
    public function __construct(private CompanyBalanceUpdaterByStp $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [TransactionCreatedDomainEventByStp::class];
    }

    public function __invoke(TransactionCreatedDomainEventByStp $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}