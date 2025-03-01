<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\update_services_by_register_company;


use Viabo\backoffice\services\domain\events\ServicesUpdateDomainEventByRegisterCompany;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class ServicesUpdateByRegisterCompany
{
    public function __construct(private ServiceRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $company): void
    {
        if (intval($company['registerStep']) !== 3) {
            return;
        }

        $services = array_map(function (array $service) {
            $serviceData = $service;
            $service = $this->repository->search($serviceData['id']);
            $service->update($serviceData);
            $this->repository->update($service);

            return $service->toArray();
        }, $company['services']);

        $this->bus->publish(new ServicesUpdateDomainEventByRegisterCompany($company['id'], $services));
    }

}