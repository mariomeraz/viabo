<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\create;


use Viabo\backoffice\costCenter\domain\CostCenter;
use Viabo\backoffice\costCenter\domain\CostCenterRepository;
use Viabo\backoffice\costCenter\domain\exceptions\CostCenterExist;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CostCenterCreator
{
    public function __construct(private CostCenterRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(
        string $userId,
        string $businessId,
        string $costCenterId,
        string $name,
        array  $users
    ): void
    {
        $this->ensureCenterCost($name);
        $users = $this->searchUsers($users);
        $folio = $this->searchFolioLast();

        $costCenter = CostCenter::create(
            $userId,
            $businessId,
            $costCenterId,
            $folio,
            $name,
            $users
        );
        $this->repository->save($costCenter);

        $this->bus->publish(...$costCenter->pullDomainEvents());
    }

    private function ensureCenterCost(string $name): void
    {
        $filters = Filters::fromValues([
            ['field' => 'name.value', 'operator' => '=', 'value' => $name]
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

    private function searchFolioLast(): string
    {
        $costCenter = $this->repository->searchFolioLast();
        return empty($costCenter) ? '1000' : $costCenter->folio();

    }
}