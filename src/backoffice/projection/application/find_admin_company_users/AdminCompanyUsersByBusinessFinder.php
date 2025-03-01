<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\application\find_admin_company_users;

use Viabo\backoffice\projection\domain\CompanyProjection;
use Viabo\backoffice\projection\domain\CompanyProjectionRepository;
use Viabo\security\user\application\find\UserResponse;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class AdminCompanyUsersByBusinessFinder
{
    public function __construct(private CompanyProjectionRepository $repository)
    {
    }

    public function __invoke(string $businessId):UserResponse
    {
        $filters = Filters::fromValues([['field' => 'businessId', 'operator' => '=', 'value' => $businessId]]);
        $projections = $this->repository->searchCriteria(new Criteria($filters));

        $companies = $this->getCompanies($projections);
        $adminCompanyUsers = $this->getAdminCompaniesUsers($projections);
        $usersWithCompanies = $this->addCompaniesInUsers($adminCompanyUsers, $companies);

        return new UserResponse(array_values($usersWithCompanies));
    }

    private function getCompanies(array $projections):array
    {
        $companies = [];
        /** @var CompanyProjection $projection */
        foreach ($projections as $projection) {
            $companies[$projection->id()] = $projection->fiscalName();
        }

        return $companies;
    }

    private function getAdminCompaniesUsers(array $projections):array
    {
        $users = [];
        /** @var CompanyProjection $projection */
        foreach ($projections as $projection) {
            if ( ! empty($projection->adminCompaniesUsers())) {
                $users = array_merge($users, $projection->adminCompaniesUsers());
            }
        }

        return $users;
    }

    private function addCompaniesInUsers(array $users, array $companies):array
    {
        $userMap = [];
        foreach ($users as $user) {
            if ( ! isset($userMap[$user['id']])) {
                unset($user['profile']);
                unset($user['createDate']);
                $userMap[$user['id']] = $user;
                $userMap[$user['id']]['companies'] = [];
            }
            $userMap[$user['id']]['companies'][] =
                    ['id' => $user['companyId'], 'name' => $companies[$user['companyId']]];
        }

        return $userMap;
    }
}
