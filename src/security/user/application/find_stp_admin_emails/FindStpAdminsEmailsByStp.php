<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_stp_admin_emails;


use Viabo\shared\domain\bus\event\DomainEventSubscriber;
use Viabo\stp\transaction\domain\events\TransactionCreatedDomainEventByStp;

final readonly class FindStpAdminsEmailsByStp implements DomainEventSubscriber
{

    public function __construct(private StpAdminsEmailsFinder $finder)
    {
    }

    public static function subscribedTo(): array
    {
        return [TransactionCreatedDomainEventByStp::class];
    }

    public function __invoke(TransactionCreatedDomainEventByStp $event): void
    {
        $this->finder->__invoke($event->toPrimitives());
    }
}