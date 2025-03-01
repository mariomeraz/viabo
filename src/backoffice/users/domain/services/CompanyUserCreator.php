<?php declare(strict_types=1);


namespace Viabo\backoffice\users\domain\services;


use Viabo\backoffice\users\domain\CompanyUser;
use Viabo\backoffice\users\domain\CompanyUserRepository;
use Viabo\security\user\application\find_user\UserQuery;
use Viabo\shared\domain\bus\query\QueryBus;

final readonly class CompanyUserCreator
{
    public function __construct(
        private CompanyUserRepository $repository,
        private QueryBus              $queryBus
    )
    {
    }

    public function __invoke(string $userId, string $companyId, string $businessId): CompanyUser
    {
        $user = $this->queryBus->ask(new UserQuery($userId, $businessId));
        $user = CompanyUser::create(
            $user->data['id'],
            $companyId,
            $user->data['profile'],
            $user->data['name'],
            $user->data['lastname'],
            $user->data['email'],
            $user->data['register']
        );
        $this->repository->save($user);

        return $user;
    }
}