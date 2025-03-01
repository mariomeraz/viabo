<?php declare(strict_types=1);


namespace Viabo\catalogs\threshold\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\catalogs\threshold\domain\Threshold;
use Viabo\catalogs\threshold\domain\ThresholdRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class ThresholdDoctrineRepository extends DoctrineRepository implements ThresholdRepository
{
    public function __construct(EntityManager $CatalogsEntityManager)
    {
        parent::__construct($CatalogsEntityManager);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Threshold::class)->matching($criteriaConvert)->toArray();
    }
}