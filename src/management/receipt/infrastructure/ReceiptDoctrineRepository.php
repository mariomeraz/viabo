<?php declare(strict_types=1);


namespace Viabo\management\receipt\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\receipt\domain\Receipt;
use Viabo\management\receipt\domain\ReceiptRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class ReceiptDoctrineRepository extends DoctrineRepository implements ReceiptRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(Receipt $receipt): void
    {
        $this->persist($receipt);
    }

    public function search(string $receiptId): Receipt|null
    {
        return $this->repository(Receipt::class)->find($receiptId);
    }

    public function matching(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Receipt::class)->matching($criteriaConvert)->toArray();
    }

    public function delete(Receipt $receipt): void
    {
        $this->remove($receipt);
    }
}