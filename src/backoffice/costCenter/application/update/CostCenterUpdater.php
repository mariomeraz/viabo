<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\update;


use Viabo\backoffice\costCenter\domain\CostCenterRepository;
use Viabo\backoffice\costCenter\domain\exceptions\CostCenterExist;
use Viabo\backoffice\costCenter\domain\exceptions\CostCenterNotExist;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CostCenterUpdater
{
    public function __construct(private CostCenterRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(
        string $userId,
        string $costCenterId,
        string $name,
        array  $users
    ): void
    {
        $costCenter = $this->repository->search($costCenterId);

        if (empty($costCenter)) {
            throw new CostCenterNotExist();
        }

        $this->ensureCenterCost($name, $costCenterId);
        $users = $this->searchUsers($users);
        $costCenter->update($userId, $name, $users);
        $this->repository->update($costCenter);

        $this->bus->publish(...$costCenter->pullDomainEvents());
    }

    private function ensureCenterCost(string $name, string $costCenterId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'name.value', 'operator' => '=', 'value' => $name],
            ['field' => 'id.value', 'operator' => '<>', 'value' => $costCenterId]
        ]);
        $costCenter = $this->repository->searchCriteria(new Criteria($filters));

        if (!empty($costCenter)) {
            throw new CostCenterExist();
        }

    }

    public function searchUsers(array $users): array
    {
        return array_map(function (string $userId) {
            return $this->repository->searchUser($userId);
        }, $users);
    }

}