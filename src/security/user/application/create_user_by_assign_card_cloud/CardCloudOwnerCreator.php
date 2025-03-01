<?php declare(strict_types=1);


namespace Viabo\security\user\application\create_user_by_assign_card_cloud;


use Viabo\security\user\domain\exceptions\UserExist;
use Viabo\security\user\domain\services\UserFinderByCriteria;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\DomainError;

final readonly class CardCloudOwnerCreator
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
        $this->ensureUser($userProfileId, $name, $lastname);

        $user = User::createCardCloudOwner($userId, $userProfileId, $name, $lastname, $email, $phone, $businessId);
        $this->repository->save($user);

        $this->bus->publish(...$user->pullDomainEvents());
    }

    private function ensureUser(string $profileId, string $name, string $lastname): void
    {
        try {
            $filters = [
                ['field' => 'profile.value', 'operator' => '=', 'value' => $profileId],
                ['field' => 'name.value', 'operator' => '=', 'value' => $name],
                ['field' => 'lastname.value', 'operator' => '=', 'value' => $lastname]
            ];
            $user = $this->finder->__invoke($filters);
        } catch (DomainError) {
            $user = null;
        }

        if (!empty($user)) {
            throw new UserExist();
        }
    }
}