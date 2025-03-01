<?php declare(strict_types=1);

namespace Viabo\backoffice\services\application\create_card_cloud_service_by_admin_stp;

use Viabo\backoffice\services\domain\events\ServicesCreatedDomainEventByAdminStp;
use Viabo\backoffice\services\domain\new\cardCloud\ServiceCardCloud;
use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\backoffice\services\domain\services\create_card_cloud\CardCloudServiceCreator;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardCloudServiceCreatorByAdminStp
{
    public function __construct(
        private ServiceRepository       $repository,
        private CardCloudServiceCreator $cardCloudServiceCreator,
        private EventBus                $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $services = $this->searchServicesCardCloud($company['id']);
        if (empty($services)) {
            $this->cardCloudServiceCreator->__invoke($company);
            $company['services'] = $this->searchServices($company['id']);
            $this->bus->publish(new ServicesCreatedDomainEventByAdminStp($company['id'], $company));
        }
    }

    public function searchServicesCardCloud(string $companyId): array
    {
        $filters = Filters::fromValues([['field' => 'companyId', 'operator' => '=', 'value' => $companyId]]);
        $services = $this->repository->searchCriteria(new Criteria($filters));
        return array_filter($services, function (Service $service) use ($filters) {
            return $service instanceof ServiceCardCloud;
        });
    }

    public function searchServices(string $companyId): array
    {
        $filters = Filters::fromValues([['field' => 'companyId', 'operator' => '=', 'value' => $companyId]]);
        $services = $this->repository->searchCriteria(new Criteria($filters));
        return array_map(function (Service $service) {
            return $service->toArray();
        }, $services);
    }
}
