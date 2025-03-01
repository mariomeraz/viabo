<?php declare(strict_types=1);


namespace Viabo\security\user\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\shared\domain\user\UserEmail;
use Viabo\security\shared\domain\user\UserId;
use Viabo\security\user\domain\User;
use Viabo\security\user\domain\UserRepository;
use Viabo\security\user\domain\UserView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class UserDoctrineRepository extends DoctrineRepository implements UserRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function search(string $userId, string $businessId = null): User|null
    {
        if (empty($businessId)) {
            return $this->repository(User::class)->find($userId);
        }
        return $this->repository(User::class)->findOneBy(['id' => $userId,'businessId.value' => $businessId]);

    }

    public function searchBy(UserEmail $email): User|null
    {
        return $this->repository(User::class)->findOneBy(['email' => $email->value()]);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaDoctrine = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(User::class)->matching($criteriaDoctrine)->toArray();
    }

    public function searchView(UserId $userId): UserView|null
    {
        return $this->repository(UserView::class)->findOneBy(['id' => $userId->value(), 'active' => '1']);
    }

    public function searchViewByCriteria(Criteria $criteria): array
    {
        $criteriaDoctrine = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(UserView::class)->matching($criteriaDoctrine)->toArray();
    }

    public function update(User $user): void
    {
        $this->entityManager()->flush($user);
    }

    public function delete(User $user): void
    {
        $this->remove($user);
    }
}