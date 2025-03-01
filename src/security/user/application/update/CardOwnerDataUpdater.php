<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\services\UserFinderByCriteria;
use Viabo\security\user\domain\UserRepository;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class CardOwnerDataUpdater
{
    public function __construct(
        private UserRepository       $repository ,
        private UserFinderByCriteria $finder ,
        private EventBus             $bus
    )
    {
    }

    public function __invoke(
        string $ownerId ,
        string $name ,
        string $lastName ,
        string $phone
    ): void
    {
        $user = $this->finder->__invoke(UserId::create($ownerId) , UserEmail::empty());
        $user->update($name , $lastName , $phone);
        $this->repository->update($user);

        $this->bus->publish(...$user->pullDomainEvents());
    }
}