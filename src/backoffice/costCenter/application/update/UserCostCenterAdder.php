<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\update;


use Viabo\backoffice\costCenter\domain\CostCenterRepository;
use Viabo\backoffice\costCenter\domain\exceptions\CostCenterNotExist;

final readonly class UserCostCenterAdder
{
    public function __construct(private CostCenterRepository $repository)
    {
    }

    public function __invoke(string $costCenterId, string $userId): void
    {
        $costCenter = $this->repository->search($costCenterId);

        if (empty($costCenter)) {
            throw new CostCenterNotExist();
        }

        $user = $this->repository->searchUser($userId);
        $costCenter->setUsers([$user]);

        $this->repository->update($costCenter);

    }
}