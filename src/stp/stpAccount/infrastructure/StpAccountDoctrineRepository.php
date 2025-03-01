<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;
use Viabo\stp\stpAccount\domain\StpAccount;
use Viabo\stp\stpAccount\domain\StpAccountRepository;

final class StpAccountDoctrineRepository extends DoctrineRepository implements StpAccountRepository
{
    public function __construct(EntityManager $StpEntityManager)
    {
        parent::__construct($StpEntityManager);
    }

    public function search(string $stpAccountId): StpAccount|null
    {
        return $this->repository(StpAccount::class)->find($stpAccountId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(StpAccount::class)->matching($criteriaConvert)->toArray();
    }

    public function searchByBusiness(string $businessId): StpAccount|null
    {
        return $this->repository(StpAccount::class)->findOneBy(['businessId.value' => $businessId]);
    }

    public function searchAll(string $stpAccountActive = '1'): array
    {
        return $this->repository(StpAccount::class)->findBy(['active.value' => $stpAccountActive]);
    }

    public function update(StpAccount $stpAccount): void
    {
        $this->entityManager()->flush($stpAccount);
    }
}
