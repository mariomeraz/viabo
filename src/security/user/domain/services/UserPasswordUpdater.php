<?php declare(strict_types=1);


namespace Viabo\security\user\domain\services;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserPassword;
use Viabo\security\user\domain\UserRepository;

final readonly class UserPasswordUpdater
{
    public function __construct(private UserRepository $repository , private UserFinderByCriteria $finder)
    {
    }

    public function __invoke(UserId $userId , UserPassword $password): User
    {
        $user = $this->finder->__invoke($userId , UserEmail::empty());
        $user->resetPassword($password);

        $this->repository->update($user);
        return $user;
    }
}