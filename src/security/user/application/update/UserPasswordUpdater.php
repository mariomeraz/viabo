<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\security\user\domain\exceptions\UserPasswordIncorrect;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class UserPasswordUpdater
{

    public function __construct(
        private UserRepository $repository,
        private EventBus       $bus
    )
    {
    }

    public function __invoke(
        string $userId,
        string $currentPassword,
        string $newPassword,
        string $confirmationPassword,
    ): void
    {
        $user = $this->repository->search($userId);

        if ($user->isDifferent($currentPassword)) {
            throw new UserPasswordIncorrect();
        }

        $user->updatePassword($newPassword, $confirmationPassword);
        $this->repository->update($user);

        $this->bus->publish(...$user->pullDomainEvents());
    }
}