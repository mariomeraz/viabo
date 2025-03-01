<?php declare(strict_types=1);

namespace Viabo\security\user\application\update_data;

use Viabo\security\user\domain\events\UserUpdatedDomainEvent;
use Viabo\security\user\domain\services\UserValidator;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class UserDataUpdater
{
    public function __construct(
        private UserRepository $repository,
        private UserValidator $validator,
        private EventBus $bus
    ){
    }

    public function __invoke(string $userId, string $name, string $lastName, string $email,string $phone): void
    {
        $this->validator->validateEmail($userId, $email);
        $user = $this->update($userId, $name, $lastName, $email,$phone);
        $this->repository->update($user);
        $this->bus->publish(new UserUpdatedDomainEvent($user->id()->value(), $user->toArray()));
    }

    public function update(string $userId, string $name, string $lastName, string $email,string $phone): User
    {
        $user = $this->repository->search($userId);
        $user->update($name, $lastName,$phone);
        $user->updateEmail($email);
        return $user;
    }
}
