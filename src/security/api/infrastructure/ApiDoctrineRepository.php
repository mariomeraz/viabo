<?php declare(strict_types=1);


namespace Viabo\security\api\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\security\api\domain\Api;
use Viabo\security\api\domain\ApiRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class ApiDoctrineRepository extends DoctrineRepository implements ApiRepository
{
    public function __construct(EntityManager $SecurityEntityManager)
    {
        parent::__construct($SecurityEntityManager);
    }

    public function searchCriteria(Criteria $criteria): array|null
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Api::class)->matching($criteriaConvert)->toArray();
    }
}