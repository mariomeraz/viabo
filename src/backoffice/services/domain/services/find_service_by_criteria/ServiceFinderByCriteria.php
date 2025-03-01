<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\services\find_service_by_criteria;


use Viabo\backoffice\services\domain\exceptions\ServiceNotExist;
use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class ServiceFinderByCriteria
{
    public function __construct(private ServiceRepository $repository)
    {
    }

    public function __invoke(array $filters, string $type): Service
    {
        $filters = Filters::fromValues($filters);
        $services = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($services)) {
            throw new ServiceNotExist();
        }

        $service = array_values(array_filter($services, function (Service $service) use ($type) {
            return $service->isSameType($type);
        }));

        return $service[0];
    }
}