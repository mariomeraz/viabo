<?php declare(strict_types=1);


namespace Viabo\catalogs\viaboService\domain;


use Doctrine\ORM\EntityManager;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class ViaboServiceDoctrineRepository extends DoctrineRepository implements ViaboServiceRepository
{
    public function __construct(EntityManager $CatalogsEntityManager)
    {
        parent::__construct($CatalogsEntityManager);
    }

    public function searchAll(): array
    {
        $query = "select * from cat_viabo_services";
        return $this->entityManager()->getConnection()->fetchAllAssociative($query);
    }
}