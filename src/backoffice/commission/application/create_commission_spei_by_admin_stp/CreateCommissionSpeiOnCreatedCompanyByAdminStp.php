<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\create_commission_spei_by_admin_stp;


use Viabo\backoffice\projection\domain\events\CompanyProjectionCreatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\DomainEventSubscriber;

final readonly class CreateCommissionSpeiOnCreatedCompanyByAdminStp implements DomainEventSubscriber
{
    public function __construct(private CommissionSpeiCreator $creator)
    {
    }

    public static function subscribedTo(): array
    {
        return [CompanyProjectionCreatedDomainEventByAdminStp::class];
    }

    public function __invoke(CompanyProjectionCreatedDomainEventByAdminStp $event): void
    {
        $this->creator->__invoke($event->toPrimitives());
    }
}