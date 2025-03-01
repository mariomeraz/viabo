<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\update_projection_balance;


use Viabo\backoffice\company\domain\events\CompanyBalanceUpdatedDomainEventByTransaction;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateProjectionBalance implements DomainEventSubscriber
{
    public function __construct(private ProjectionBalanceUpdater $updater)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyBalanceUpdatedDomainEventByTransaction::class];
    }

    public function __invoke(CompanyBalanceUpdatedDomainEventByTransaction $event): void
    {
        $this->updater->__invoke($event->toPrimitives());
    }
}