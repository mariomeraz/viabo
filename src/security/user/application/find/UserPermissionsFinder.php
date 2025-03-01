<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\exceptions\UserNotExist;
use Viabo\security\user\domain\UserRepository;

final readonly class UserPermissionsFinder
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function __invoke(string $userId): UserPermissionsResponse
    {
        $user = $this->repository->searchView(new UserId($userId));

        if (empty($user)) {
            throw new UserNotExist('');
        }

        return new UserPermissionsResponse($user->permissions());
    }
}