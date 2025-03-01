<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_card_cloud_owner_user;


use Viabo\security\user\application\find\UserResponse;
use Viabo\security\user\domain\exceptions\UserNotCardCloudOwner;
use Viabo\security\user\domain\services\UserFinder as UserFinderService;

final readonly class CardCloudOwnerUserFinder
{
    public function __construct(private UserFinderService $finder)
    {
    }

    public function __invoke(string $userId, string $businessId): UserResponse
    {
        $user = $this->finder->__invoke($userId, $businessId);

        if ($user->isNotOwnerCardCloud()) {
            throw new UserNotCardCloudOwner();
        }

        return new UserResponse($user->toArray());
    }
}