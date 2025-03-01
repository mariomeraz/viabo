<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\create_commission_spei_by_admin_stp;


use Viabo\backoffice\commission\domain\CommissionRepository;
use Viabo\backoffice\commission\domain\events\CommissionSpeiCreatedDomainEventByAdminStp;
use Viabo\backoffice\commission\domain\spei\CommissionSpei;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CommissionSpeiCreator
{
    public function __construct(
        private CommissionRepository $repository,
        private EventBus $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $commission = CommissionSpei::create(
            $company['id'],
            $company['commissions']['speiOut'],
            $company['commissions']['speiIn'],
            $company['commissions']['internal'],
            $company['commissions']['feeStp'],
            $company['createdByUser'],
            $company['createDate'],
        );
        $this->repository->save($commission);

        $company['commissions'] = [$commission->toArray()];
        $this->bus->publish(new CommissionSpeiCreatedDomainEventByAdminStp($company['id'], $company));
    }

}