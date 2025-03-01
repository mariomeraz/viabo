<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\update_users_by_admin_stp;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\backoffice\users\domain\events\CompanyUsersUpdatedDomainEventByAdminStp;
use Viabo\backoffice\users\domain\services\CompanyUserCreator;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyUsersUpdaterByAdminSTP
{
    public function __construct(
        private CompanyUserRepository $repository,
        private CompanyUserCreator    $creator,
        private EventBus              $bus
    )
    {
    }

    public function __invoke(array $company): void
    {
        $this->deleteCompaniesAdmins($company['id']);
        $this->addCompaniesAdmins($company);
        $company['users'] = $this->searchUsers($company['id']);
        $this->bus->publish(new CompanyUsersUpdatedDomainEventByAdminStp($company['id'], $company));
    }

    private function deleteCompaniesAdmins(string $companyId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'companyId', 'operator' => '=', 'value' => $companyId],
            ['field' => 'profileId.value', 'operator' => '=', 'value' => '7']
        ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        array_map(function (CompanyUser $user) {
            $this->repository->delete($user);
        }, $users);
    }

    private function addCompaniesAdmins(array $company): void
    {
        array_map(function (string $userId) use ($company) {
            $this->creator->__invoke($userId, $company['id'], $company['businessId']);
        }, $company['users']);
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