<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\update_commissions_by_admin_stp;


use Viabo\backoffice\commission\domain\CommissionRepository;
use Viabo\backoffice\commission\domain\events\CommissionSpeiUpdatedDomainEventByAdminStp;
use Viabo\backoffice\commission\domain\spei\CommissionSpei;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CommissionSpeiUpdater
{
    public function __construct(
        private CommissionRepository $repository,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $commission = $this->repository->search($company['id']);
        if (empty($commission)) {
            $commission = CommissionSpei::create(
                $company['id'],
                $company['commissions']['speiOut'],
                $company['commissions']['speiIn'],
                $company['commissions']['internal'],
                $company['commissions']['feeStp'],
                $company['createdByUser'],
                $company['createDate']
            );
            $this->repository->save($commission);
        } else {
            $commission->update($company);
            $this->repository->update($commission);
        }

        $company['commissions'] = [$commission->toArray()];
        $this->bus->publish(new CommissionSpeiUpdatedDomainEventByAdminStp($company['id'], $company));
    }
}