<?php declare(strict_types=1);


namespace Viabo\security\session\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\session\domain\Session;
use Viabo\security\session\domain\SessionRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class SessionDoctrineRepository extends DoctrineRepository implements SessionRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function save(Session $session): void
    {
        $this->persist($session);
    }

    public function search(string $userId): Session|null
    {
        return $this->repository(Session::class)->findOneBy(['userId' => $userId, 'active.value' => '1']);
    }

    public function matching(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Session::class)->matching($criteriaConvert)->toArray();
    }

    public function update(Session $session): void
    {
        $this->entityManager()->flush($session);
    }
}