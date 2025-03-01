<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_admins_emails;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\stp\transaction\domain\events\TransactionUpdatedDomainEventByStpSpeiOut;

final readonly class FindCompaniesAdminsEmailsByTransactionUpdated implements DomainEventSubscriber
{
    public function __construct(private CompaniesAdminsEmailsFinder $finder)
    {
    }

    public static function subscribedTo(): array
    {
        return [TransactionUpdatedDomainEventByStpSpeiOut::class];
    }

    public function __invoke(TransactionUpdatedDomainEventByStpSpeiOut $event): void
    {
        $this->finder->__invoke($event->toPrimitives());
    }
}