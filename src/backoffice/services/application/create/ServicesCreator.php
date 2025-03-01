<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\create;


use Viabo\backoffice\services\domain\Service;
use Viabo\backoffice\services\domain\ServiceRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class ServicesCreator
{
    public function __construct(private ServiceRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(string $commerceId, array $services): void
    {
        $this->repository->delete($commerceId);

        array_map(function (array $service) use ($commerceId) {
            $service = Service::create(
                $commerceId,
                $service['type'],
                $service['cardNumbers'],
                $service['cardUse'],
                $service['personalized']
            );
            $this->repository->save($service);

            $this->bus->publish(...$service->pullDomainEvents());
        }, $services);
    }

}