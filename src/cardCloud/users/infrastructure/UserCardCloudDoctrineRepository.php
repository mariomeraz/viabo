<?php declare(strict_types=1);


namespace Viabo\cardCloud\users\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\cardCloud\users\domain\UserCardCloud;
use Viabo\cardCloud\users\domain\UserCardCloudRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class UserCardCloudDoctrineRepository extends DoctrineRepository implements UserCardCloudRepository
{
    public function __construct(EntityManager $CardCloudEntityManager)
    {
        parent::__construct($CardCloudEntityManager);
    }

    public function save(UserCardCloud $owner): void
    {
        $this->persist($owner);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(UserCardCloud::class)->matching($criteriaConvert)->toArray();
    }

    public function update(UserCardCloud $user): void
    {
        $this->entityManager()->flush($user);
    }
}