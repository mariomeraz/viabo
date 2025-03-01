<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_user;


use Viabo\security\user\application\find\UserResponse;
use Viabo\security\user\domain\services\UserFinder as UserFinderService;

final readonly class UserFinder
{
    public function __construct(private UserFinderService $finder)
    {
    }

    public function __invoke(string $userId, string $businessId): UserResponse
    {
        $user = $this->finder->__invoke($userId, $businessId);
        return new UserResponse($user->toArray());
    }
}