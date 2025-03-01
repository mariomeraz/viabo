<?php declare(strict_types=1);

namespace Viabo\security\user\application\update_active_status;

use Viabo\security\user\domain\events\UserUpdatedDomainEvent;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class UserActiveStatusUpdater
{
    public function __construct(
        private UserRepository $repository,
        private EventBus       $bus
    )
    {
    }

    public function __invoke(string $userId, string $active): void
    {
        $user = $this->repository->search($userId);
        $user->updateActive($active);
        $this->repository->update($user);

        $this->bus->publish(new UserUpdatedDomainEvent($user->id()->value(), $user->toArray()));
    }
}
