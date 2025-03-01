<?php declare(strict_types=1);


namespace Viabo\catalogs\viaboService\application\find;



use Viabo\catalogs\viaboService\domain\ViaboServiceRepository;

final readonly class ViaboServicesFinder
{
    public function __construct(private ViaboServiceRepository $repository)
    {
    }

    public function __invoke(): ViaboServicesResponse
    {
        $services = $this->repository->searchAll();
        return new ViaboServicesResponse($services);
    }
}