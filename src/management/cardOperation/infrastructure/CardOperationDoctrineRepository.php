<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\cardOperation\domain\CardOperation;
use Viabo\management\cardOperation\domain\CardOperationRepository;
use Viabo\management\cardOperation\domain\CardOperations;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CardOperationDoctrineRepository extends DoctrineRepository implements CardOperationRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(CardOperations $operations): void
    {
        foreach ($operations->getIterator() as $cardOperation) {
            $this->persist($cardOperation);
        }
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CardOperation::class)->matching($criteriaConvert)->toArray();
    }

    public function searchDateRange(CardNumber $cardNumber , string $initialDate , string $finalDate): array
    {
        $query = "select co from Viabo\management\cardOperation\domain\CardOperation co
                    where (co.originCard.value = :cardNumber or co.destinationCard.value = :cardNumber) and
                    co.registerDate.value BETWEEN :initial and :final";
        $statement = $this->entityManager()->createQuery($query);
        $statement->setParameter('cardNumber' , $cardNumber->value());
        $statement->setParameter('initial' , $initialDate);
        $statement->setParameter('final' , $finalDate);
        return $statement->getResult();
    }

    public function searchAll(): array
    {
        return $this->repository(CardOperation::class)->findAll();
    }

    public function update(CardOperations $operations): void
    {
        foreach ($operations->getIterator() as $cardOperation) {
            $this->entityManager()->flush($cardOperation);
        }
    }
}