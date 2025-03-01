<?php declare(strict_types=1);


namespace Viabo\backoffice\services\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\services\domain\Service;
use Viabo\backoffice\services\domain\ServiceRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class ServiceDoctrineRepository extends DoctrineRepository implements ServiceRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function save(Service $service): void
    {
        $this->persist($service);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Service::class)->matching($criteriaConvert)->toArray();
    }

    public function update(Service $service): void
    {
        $this->entityManager()->flush($service);
    }

    public function delete(string $companyId): void
    {
        $this->entityManager()->getConnection()->delete('t_business_commerces_services', ['CommerceId' => $companyId]);
    }
}