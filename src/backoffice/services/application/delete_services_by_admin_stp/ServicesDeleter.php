<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\delete_services_by_admin_stp;


use Viabo\backoffice\services\domain\new\Service;
use Viabo\backoffice\services\domain\new\ServiceRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class ServicesDeleter
{
    public function __construct(private ServiceRepository $repository)
    {
    }

    public function __invoke(string $companyId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'companyId', 'operator' => '=', 'value' => $companyId]
        ]);
        $services = $this->repository->searchCriteria(new Criteria($filters));

        array_map(function (Service $service) {
            $this->repository->delete($service);
        }, $services);
    }

}