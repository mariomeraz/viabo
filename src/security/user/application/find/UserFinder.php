<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\security\user\domain\services\UserFinderByCriteria as UserFinderService;

final readonly class UserFinder
{

    public function __construct(private UserFinderService $finder)
    {
    }

    public function __invoke(string $userId, string $username): UserResponse
    {
        $filters = [];
        if (empty($username)) {
            $filters[] = ['field' => 'id', 'operator' => '=', 'value' => $userId];
        } else {
            $filters[] = ['field' => 'email', 'operator' => '=', 'value' => $username];
        }

        $user = $this->finder->__invoke($filters);
        return new UserResponse($user->toArray());
    }
}