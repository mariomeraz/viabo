<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\management\card\application\find\CardQueryByOwner;
use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\exceptions\UserExist;
use Viabo\security\user\domain\services\UserFinderByCriteria;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\bus\query\QueryBus;
use Viabo\shared\domain\DomainError;

final readonly class DemoUserValidator
{
    public function __construct(
        private UserRepository       $repository ,
        private UserFinderByCriteria $finder ,
        private QueryBus             $queryBus ,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(UserEmail $userEmail): void
    {
        $user = $this->searchUser($userEmail);

        if (empty($user)) {
            return;
        }

        if ($user->isLegalRepresentative()) {
            throw new UserExist();
        }

        if ($this->hasAssignedCards($user)) {
            throw new UserExist();
        }

        $user->setEventDeleted();
        $this->bus->publish(...$user->pullDomainEvents());

        $this->repository->delete($user);

    }

    private function searchUser(UserEmail $email): User|null
    {
        try {
            $filters = [['field' => 'email', 'operator' => '=', 'value' => $email->value()]];
            return $this->finder->__invoke($filters);
            //return $this->finder->__invoke( [UserId::empty(), $email]);
        } catch (DomainError) {
            return null;
        }
    }

    private function hasAssignedCards(User $user): bool
    {
        $card = $this->searchCardBy($user);
        return !empty($card);
    }

    private function searchCardBy(User $user): array
    {
        $card = $this->queryBus->ask(new CardQueryByOwner($user->id()->value()));
        return $card->data;
    }

}