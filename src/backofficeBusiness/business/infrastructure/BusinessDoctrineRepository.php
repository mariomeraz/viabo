<?php declare(strict_types=1);


namespace Viabo\backofficeBusiness\business\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backofficeBusiness\business\domain\Business;
use Viabo\backofficeBusiness\business\domain\BusinessRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class BusinessDoctrineRepository extends DoctrineRepository implements BusinessRepository
{
    public function __construct(EntityManager $BusinessEntityManager)
    {
        parent::__construct($BusinessEntityManager);
    }

    public function search(string $businessId): Business|null
    {
        return $this->repository(Business::class)->find($businessId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Business::class)->matching($criteriaConvert)->toArray();
    }
}