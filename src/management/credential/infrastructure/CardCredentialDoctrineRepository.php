<?php declare(strict_types=1);


namespace Viabo\management\credential\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\credential\domain\CardCredential;
use Viabo\management\credential\domain\CardCredentialRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CardCredentialDoctrineRepository extends DoctrineRepository implements CardCredentialRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(CardCredential $credential): void
    {
        $this->persist($credential);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CardCredential::class)->matching($criteriaConvert)->toArray();
    }

    public function update(CardCredential $credential): void
    {
        $this->entityManager()->flush($credential);
    }
}