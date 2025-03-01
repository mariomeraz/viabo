<?php declare(strict_types=1);


namespace Viabo\security\user\domain\services;


use Viabo\security\user\domain\exceptions\UserNotExist;
use Viabo\security\user\domain\exceptions\UserRepeated;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\security\user\domain\UserView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class UserFinderByCriteria
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(array $filters): User
    {
        $filters = Filters::fromValues($filters);
        //var_dump($filters);
        $user = $this->repository->searchCriteria(new Criteria($filters));
        
        if (empty($user)) {
            throw new UserNotExist();
        }

        return $user[0];
    }

    public function view(array $filters): UserView
    {
        $filters = Filters::fromValues($filters);
        $user = $this->repository->searchViewByCriteria(new Criteria($filters));

        if (empty($user)) {
            throw new UserNotExist();
        }

        if(count($user) > 1){
            throw new UserRepeated();
        }

        return $user[0];
    }
}