<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\delete_users_by_admin_stp;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CompanyUsersDeleter
{
    public function __construct(private CompanyUserRepository $repository)
    {
    }

    public function __invoke(string $companyId): void
    {
        $filters = Filters::fromValues([
            ['field' => 'companyId' , 'operator' => '=' , 'value' => $companyId ]
        ]);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        array_map(function (CompanyUser $user) {
            $this->repository->delete($user);
        }, $users);

    }
}