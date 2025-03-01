<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_companies_admins_by_business;


use Viabo\security\user\application\find\UserResponse;
use Viabo\security\user\application\find\UsersFinderByCriteria;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AdministratorsOfCompaniesQueryHandler implements QueryHandler
{
    public function __construct(private UsersFinderByCriteria $finder)
    {
    }

    public function __invoke(AdministratorsOfCompaniesQuery $query): Response
    {
        $administratorCompanies = '7';
        $filters = [
            ['field' => 'profile.value', 'operator' => '=', 'value' => $administratorCompanies],
            ['field' => 'businessId.value', 'operator' => '=', 'value' => $query->businessId],
            ['field' => 'active.value', 'operator' => '=', 'value' => '1']
        ];
        $users = $this->finder->__invoke($filters);
        $users = $this->filterData($users->data);

        return new UserResponse($users);
    }

    private function filterData(array $users): array
    {
        return array_map(function (array $user) {
            return ['id' => $user['id'], 'name' => "{$user['name']} {$user['lastname']}"];
        }, $users);
    }
}