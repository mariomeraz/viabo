<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\create_services_by_admin_stp;


use Viabo\backoffice\services\domain\events\ServicesCreatedDomainEventByAdminStp;
use Viabo\backoffice\services\domain\services\create_card_cloud\CardCloudServiceCreator;
use Viabo\backoffice\services\domain\services\create_spei_service\StpServiceCreator;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class ServicesCreatorByAdminStp
{
    public function __construct(
        private StpServiceCreator       $stpServiceCreator,
        private CardCloudServiceCreator $cardCloudServiceCreator,
        private EventBus                $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $stpService = $this->stpServiceCreator->__invoke($company);
        $cardCloud = $this->cardCloudServiceCreator->__invoke($company);
        $company['services'] = [$stpService, $cardCloud];
        $this->bus->publish(new ServicesCreatedDomainEventByAdminStp($company['id'], $company));
    }

}
