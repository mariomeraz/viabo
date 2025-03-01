<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\FundingOrderReferenceNumber;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\FundingOrderView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class FundingOrderDoctrineRepository extends DoctrineRepository implements FundingOrderRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(FundingOrder $conciliation): void
    {
        $this->persist($conciliation);
    }

    public function search(FundingOrderId $conciliationId): ?FundingOrder
    {
        return $this->repository(FundingOrder::class)->find($conciliationId->value());
    }

    public function searchReferenceNumber(FundingOrderReferenceNumber $referenceNumber): ?FundingOrder
    {
        return $this->repository(FundingOrder::class)->findOneBy([
            'referenceNumber.value' => $referenceNumber->value()
        ]);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(FundingOrder::class)->matching($criteriaConvert)->toArray();
    }

    public function searchView(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(FundingOrderView::class)->matching($criteriaConvert)->toArray();
    }

    public function update(FundingOrder $fundingOrder): void
    {
        $this->entityManager()->flush($fundingOrder);
    }
}