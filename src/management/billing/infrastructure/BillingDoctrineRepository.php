<?php declare(strict_types=1);


namespace Viabo\management\billing\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\billing\domain\Billing;
use Viabo\management\billing\domain\BillingId;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\management\billing\domain\PayCashBilling;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class BillingDoctrineRepository extends DoctrineRepository implements BillingRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(Billing $deposit): void
    {
        $this->persist($deposit);
    }

    public function savePayCashBilling(PayCashBilling $billing): void
    {
        $this->persist($billing);
    }

    public function search(BillingId $billingId): Billing|null
    {
        return $this->repository(Billing::class)->find($billingId->value());
    }

    public function searchCriteria(Criteria $criteria): array|null
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Billing::class)->matching($criteriaConvert)->toArray();
    }

    public function delete(Billing $billing): void
    {
        $this->remove($billing);
    }

    public function searchBillingPayCashCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(PayCashBilling::class)->matching($criteriaConvert)->toArray();
    }
}