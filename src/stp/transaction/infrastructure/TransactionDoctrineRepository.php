<?php declare(strict_types=1);


namespace Viabo\stp\transaction\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;
use Viabo\stp\transaction\domain\Transaction;
use Viabo\stp\transaction\domain\TransactionRepository;
use Viabo\stp\transaction\domain\TransactionStatusId;
use Viabo\stp\transaction\domain\TransactionTypeId;

final class TransactionDoctrineRepository extends DoctrineRepository implements TransactionRepository
{
    public function __construct(EntityManager $StpEntityManager)
    {
        parent::__construct($StpEntityManager);
    }

    public function save(Transaction $transaction): void
    {
        $this->persist($transaction);
    }

    public function search(string $transactionId): Transaction|null
    {
        return $this->repository(Transaction::class)->find($transactionId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Transaction::class)->matching($criteriaConvert)->toArray();
    }

    public function searchAll(): array
    {
        return $this->repository(Transaction::class)->findAll();
    }

    public function searchType(string $id): TransactionTypeId|null
    {
        return $this->repository(TransactionTypeId::class)->find($id);
    }

    public function searchStatus(string $id): TransactionStatusId|null
    {
        return $this->repository(TransactionStatusId::class)->find($id);
    }

    public function searchByAccount(
        string $initialDate,
        string $endDate,
        string $account,
        string $order,
        ?int   $limit
    ): array
    {
        $dql = 'SELECT t FROM Viabo\stp\transaction\domain\Transaction t 
             JOIN t.typeId tp    
             WHERE t.createDate.value BETWEEN :initialDate and :endDate
             and (t.sourceAccount.value = :sourceAccount 
             OR (tp.id = 2 and t.destinationAccount.value = :destinationAccount))
             ORDER BY t.createDate.value ' . $order;
        $query = $this->entityManager()->createQuery($dql);
        $query->setParameter('initialDate', $initialDate);
        $query->setParameter('endDate', $endDate);
        $query->setParameter('sourceAccount', $account);
        $query->setParameter('destinationAccount', $account);
        $query->setMaxResults($limit);
        return $query->getResult();
    }

    public function update(Transaction $transaction): void
    {
        $this->entityManager()->flush($transaction);
    }

    public function searchByBusinessId(string $date, string $businessId): array
    {
        $query = 'Call statementCCMovements(:date, :businessId)';
        $query = $this->entityManager()->getConnection()->prepare($query);
        $query->bindValue('date', $date);
        $query->bindValue('businessId', $businessId);
        return $query->executeQuery()->fetchAllAssociative();
    }
}