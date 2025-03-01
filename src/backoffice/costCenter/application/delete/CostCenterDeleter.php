<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\delete;


use Viabo\backoffice\costCenter\domain\CostCenterRepository;

final readonly class CostCenterDeleter
{
    public function __construct(private CostCenterRepository $repository)
    {
    }

    public function __invoke(string $costCenterId): void
    {
        $costCenter = $this->repository->search($costCenterId);

        if (!empty($costCenter)) {
            $this->repository->delete($costCenter);
        }

    }
}