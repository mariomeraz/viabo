<?php declare(strict_types=1);


namespace Viabo\backoffice\commerceUser\application\create;


use Viabo\backoffice\commerceUser\domain\CommerceUser;
use Viabo\backoffice\commerceUser\domain\CommerceUserKey;
use Viabo\backoffice\commerceUser\domain\CommerceUserRepository;
use Viabo\backoffice\commerceUser\domain\exceptions\CommerceUserNotSameCommerce;
use Viabo\backoffice\commerceUser\domain\services\CommerceUserFinder;
use Viabo\backoffice\shared\domain\company\CompanyId;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\DomainError;

final readonly class CommerceUserCreator
{
    public function __construct(
        private CommerceUserRepository $repository ,
        private CommerceUserFinder     $finder ,
        private EventBus               $bus
    )
    {
    }

    public function __invoke(CompanyId $commerceId , CommerceUserKey $userId): void
    {
        $commerceUser = $this->search($userId);

        if (!empty($commerceUser) && $commerceUser->isDifferent($commerceId)) {
            throw new CommerceUserNotSameCommerce();
        }

        if (empty($commerceUser)) {
            $commerceUser = CommerceUser::create($commerceId , $userId);
            $this->repository->save($commerceUser);

            $this->bus->publish(...$commerceUser->pullDomainEvents());
        }

    }

    private function search(CommerceUserKey $userId): CommerceUser|null
    {
        try {
            return $this->finder->__invoke($userId);
        } catch (DomainError) {
            return null;
        }
    }
}