<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\update;


use Viabo\backoffice\services\domain\Service;
use Viabo\backoffice\services\domain\ServiceRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CommerceServiceUpdater
{
    public function __construct(private ServiceRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(
        string $commerceId ,
        string $serviceType ,
        string $serviceActive ,
    ): void
    {
        $service = $this->searchService($commerceId , $serviceType);

        if (empty($service)) {
            $service = Service::fromType($commerceId , $serviceType);
            $this->repository->save($service);
        } else {
            $service->updateActive($serviceActive);
            $this->repository->update($service);
        }

        $this->bus->publish(...$service->pullDomainEvents());
    }

    private function searchService(string $commerceId , string $serviceType): Service|null
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId] ,
            ['field' => 'type.value' , 'operator' => '=' , 'value' => $serviceType]
        ]);
        $service = $this->repository->searchCriteria(new Criteria($filters));

        return empty($service) ? null : $service[0];
    }
}