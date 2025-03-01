<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user_by_register;


use Viabo\security\user\application\find\TokenDataResponse;
use Viabo\security\user\application\find\UserResponse;
use Viabo\security\user\domain\exceptions\UserNotExist;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class UserFinderByRegisterCompany
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $email): UserResponse
    {
        $filters = Filters::fromValues([['field' => 'email', 'operator' => '=', 'value' => $email]]);
        $user = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($user)) {
            throw new UserNotExist($email);
        }

        return new UserResponse($user[0]->toArray());
    }
}