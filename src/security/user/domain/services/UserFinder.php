<?php declare(strict_types=1);


namespace Viabo\security\user\domain\services;


use Viabo\security\user\domain\exceptions\UserNotExist;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;

final readonly class UserFinder
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userId, string $businessId = null): User
    {
        $user = $this->repository->search($userId, $businessId);

        if (empty($user)) {
            throw new UserNotExist();
        }

        return $user;
    }
}