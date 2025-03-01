<?php declare(strict_types=1);


namespace Viabo\security\user\domain\services;


use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class UserPasswordReset
{
    public function __construct(
        private UserRepository $repository,
        private UserFinder     $finder,
        private EventBus       $bus
    )
    {
    }

    public function __invoke(string $userId): void
    {
        $user = $this->finder->__invoke($userId);
        $user->resetPassword();
        $this->repository->update($user);

        $this->bus->publish(...$user->pullDomainEvents());
    }
}