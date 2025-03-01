<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\security\user\domain\exceptions\UserBusinessIdNotDefined;
use Viabo\security\user\domain\services\UserFinderByCriteria as UserFinderByCriteriaService;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserView;

final readonly class UserFinderByCriteria
{
    public function __construct(private UserFinderByCriteriaService $finder)
    {
    }

    public function __invoke(array $filters, bool $searchByView = false): UserResponse
    {
        $user = !$searchByView ? $this->finder->__invoke($filters) : $this->finder->view($filters);
        $this->ensureBusiness($user);
        return new UserResponse($user->toArray());
    }

    private function ensureBusiness(UserView|User $user): void
    {
        if($user->isNotBusinessId()) {
            throw new UserBusinessIdNotDefined();
        }
    }
}