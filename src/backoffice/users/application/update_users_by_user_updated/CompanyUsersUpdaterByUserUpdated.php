<?php declare(strict_types=1);

namespace Viabo\backoffice\users\application\update_users_by_user_updated;

use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\backoffice\users\domain\events\CompanyUsersUpdatedDomainEventByAdminStp;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyUsersUpdaterByUserUpdated
{

    public function __construct(private CompanyUserRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(array $user): void
    {
        $filters = Filters::fromValues([['field' => 'userId.value', 'operator' => '=', 'value' => $user['id']]]);
        $companyUsers = $this->repository->searchCriteria(new Criteria($filters));
        array_map(function (CompanyUser $companyUser) use ($user) {
            $companyUser->update($user['name'], $user['lastname'], $user['email']);
            $this->repository->update($companyUser);
            $companyUser = $companyUser->toArray();
            $users = $this->searchUsers($companyUser['companyId']);

            $this->bus->publish(new CompanyUsersUpdatedDomainEventByAdminStp(
                $companyUser['companyId'],
                ['id' => $companyUser['companyId'], 'users' => $users]

            ));
        }, $companyUsers);

    }

    private function searchUsers(string $companyId): array
    {
        $filters = Filters::fromValues([['field' => 'companyId', 'operator' => '=', 'value' => $companyId]]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        return array_map(function (CompanyUser $user) {
            return $user->toArray();
        }, $users);
    }
}
