<?php declare(strict_types=1);


namespace Viabo\security\user\application\create;


use Viabo\security\user\domain\exceptions\UserExist;
use Viabo\security\user\domain\services\UserFinderByCriteria;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\DomainError;

final readonly class UserCreator
{
    public function __construct(
        private UserRepository       $repository,
        private UserFinderByCriteria $finder,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(
        string $userId,
        string $userProfileId,
        string $name,
        string $lastname,
        string $phone,
        string $email,
        string $businessId = ''
    ): void
    {
        $this->ensureUser($email);

        $user = User::create($userId, $userProfileId, $name, $lastname, $email, $phone, $businessId);
        $this->repository->save($user);

        $this->bus->publish(...$user->pullDomainEvents());
    }

    private function ensureUser(string $email): void
    {
        try {
            $filters = [['field' => 'email', 'operator' => '=', 'value' => $email]];
            $user = $this->finder->__invoke($filters);
        } catch (DomainError) {
            $user = null;
        }

        if (!empty($user)) {
            throw new UserExist();
        }
    }
}