<?php declare(strict_types=1);


namespace Viabo\security\user\application\login;


use Viabo\security\user\domain\events\UserLoggedDomainEvent;
use Viabo\security\user\domain\exceptions\UserNoAccess;
use Viabo\security\user\domain\services\UserFinderByCriteria;
use Viabo\security\user\domain\User;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\DomainError;

final readonly class UserLogin
{
    public function __construct(
        private UserFinderByCriteria $finder,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(string $email, string $password): void
    {
        $user = $this->searchUser($email);

        if ($user->isInvalidPassword($password)) {
            throw new UserNoAccess();
        }

        $this->bus->publish(new UserLoggedDomainEvent($user->id()->value(), $user->toArray()));
    }

    private function searchUser(string $email): User
    {
        try {
            $filters = [
                ['field' => 'email', 'operator' => '=', 'value' => $email],
                ['field' => 'active.value', 'operator' => '=', 'value' => '1']
            ];
            return $this->finder->__invoke($filters);
        } catch (DomainError) {
            throw new UserNoAccess();
        }
    }
}