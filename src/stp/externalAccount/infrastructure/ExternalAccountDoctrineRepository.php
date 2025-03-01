<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;
use Viabo\stp\externalAccount\domain\ExternalAccount;
use Viabo\stp\externalAccount\domain\ExternalAccountRepository;

final class ExternalAccountDoctrineRepository extends DoctrineRepository implements ExternalAccountRepository
{
    public function __construct(EntityManager $StpEntityManager)
    {
        parent::__construct($StpEntityManager);
    }

    public function save(ExternalAccount $externalAccount): void
    {
        $this->persist($externalAccount);
    }

    public function search(string $externalAccountId): ExternalAccount|null
    {
        return $this->repository(ExternalAccount::class)->find($externalAccountId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(ExternalAccount::class)->matching($criteriaConvert)->toArray();
    }

    public function update(ExternalAccount $externalAccount): void
    {
        $this->entityManager()->flush($externalAccount);
    }
}