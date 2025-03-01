<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\update_commissions_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class UpdateCommissionSpeiOnCompanyUpdatedByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CommissionSpeiUpdater $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyProjectionUpdatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyProjectionUpdatedDomainEventByAdminStp $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}