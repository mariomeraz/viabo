<?php declare(strict_types=1);


namespace Viabo\tickets\supportReason\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;
use Viabo\tickets\supportReason\domain\SupportReason;
use Viabo\tickets\supportReason\domain\SupportReasonRepository;

final class SupportReasonDoctrineRepository extends DoctrineRepository implements SupportReasonRepository
{
    public function __construct(EntityManager $TicketsEntityManager)
    {
        parent::__construct($TicketsEntityManager);
    }

    public function save(SupportReason $supportReason): void
    {
        $this->persist($supportReason);
    }

    public function search(string $supportReasonId): SupportReason|null
    {
        return $this->repository(SupportReason::class)->find($supportReasonId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(SupportReason::class)->matching($criteriaConvert)->toArray();
    }

    public function searchAll(): array
    {
        return $this->repository(SupportReason::class)->findBy(['active.value' => '1']);
    }
}