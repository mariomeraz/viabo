<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\infrastructure;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\CardMovementLog;
use Viabo\management\cardMovement\domain\CardMovementRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CardMovementDoctrineRepository extends DoctrineRepository implements CardMovementRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(CardMovement $cardMovement): void
    {
        $this->persist($cardMovement);
        $this->entityManager()->clear();
    }

    public function saveLog(CardMovementLog $log): void
    {
        $this->persist($log);
    }

    public function matching(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CardMovement::class)->matching($criteriaConvert)->toArray();
    }

    public function matchingView(Criteria $criteria): array
    {
        $rsm = new ResultSetMappingBuilder($this->entityManager());
        $rsm->addRootEntityFromClassMetadata('Viabo\management\cardMovement\domain\CardMovementView' , 'v');
        $query = $this->entityManager()->createNativeQuery(
            'call managementCardsMovements(:filters,:limit,:offset)' ,
            $rsm
        );
        $query->setParameter('filters' , $criteria->getWhereSQL());
        $query->setParameter('limit' , $criteria->limit() ?? '');
        $query->setParameter('offset' , $criteria->offset() ?? '');
        return $query->getResult();
    }

    public function delete(CardMovement $cardMovement): void
    {
        $this->remove($cardMovement);
    }
}
