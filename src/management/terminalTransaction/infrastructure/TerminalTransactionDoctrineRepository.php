<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\infrastructure;

use Doctrine\ORM\EntityManager;
use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransaction\domain\CommercePay;
use Viabo\management\terminalTransaction\domain\CommercePayReference;
use Viabo\management\terminalTransaction\domain\TerminalTransactionRepository;
use Viabo\management\terminalTransaction\domain\CommercePayView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class TerminalTransactionDoctrineRepository extends DoctrineRepository implements TerminalTransactionRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(CommercePay $commercePay): void
    {
        $this->persist($commercePay);
    }

    public function search(CommercePayId $id): CommercePay|null
    {
        return $this->repository(CommercePay::class)->find($id->value());
    }

    public function searchView(CommercePayId $commercePayId): CommercePayView|null
    {
        return $this->repository(CommercePayView::class)->find($commercePayId->value());
    }

    public function searchCriteriaView(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CommercePayView::class)->matching($criteriaConvert)->toArray();

    }

    public function searchBy(CommercePayReference $referenceId): CommercePay|null
    {
        return $this->repository(CommercePay::class)->findOneBy(['reference.value' => $referenceId->value()]);
    }

    public function update(CommercePay $commercePay): void
    {
        $this->entityManager()->flush($commercePay);
    }
}
