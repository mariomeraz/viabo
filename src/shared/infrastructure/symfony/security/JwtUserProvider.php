<?php declare(strict_types=1);


namespace Viabo\shared\infrastructure\symfony\security;


use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Viabo\security\user\application\find\UserFinder;
use Viabo\security\user\domain\exceptions\UserNotExist;

final class JwtUserProvider implements UserProviderInterface
{
    public function __construct(private UserFinder $userFinder) {
    }

    public function loadUserByIdentifier(string $identifier): JwtUser
    {
        return $this->loadUser($identifier);
    }

    public function loadUserByUsername(string $username): JwtUser
    {
        return $this->loadUserByIdentifier($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === JwtUser::class;
    }

    public function loadUser(string $userId): JwtUser
    {
        try {
//            $user = ($this->userFinder)(new UserFinderRequest($userId));
//            return new JwtUser(
//                $user->id(),
//                $user->email(),
//                $user->password()
//            );
            return new JwtUser('','','');
        } catch (UserNotExist $exception) {
            throw new UserNotFoundException($exception->getMessage());
        }
    }
}