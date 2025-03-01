<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user_by_id;


use Viabo\security\user\application\find\UserResponse;
use Viabo\security\user\domain\exceptions\UserNotExist;
use Viabo\security\user\domain\UserRepository;

final readonly class UserFinderById
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userId): UserResponse
    {
        $user = $this->repository->search($userId);
        if (empty($user)) {
            throw new UserNotExist();
        }
        return new UserResponse($user->toArray());
    }
}