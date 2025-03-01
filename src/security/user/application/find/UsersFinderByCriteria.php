<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class UsersFinderByCriteria
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(array $filters): UserResponse
    {
        $filters = Filters::fromValues($filters);
        $users = $this->repository->searchCriteria(new Criteria($filters));

        return new UserResponse(array_map(function (User $user) {
            return $user->toArray();
        } , $users));
    }
}