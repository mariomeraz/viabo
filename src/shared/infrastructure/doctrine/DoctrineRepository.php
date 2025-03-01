<?php

namespace Viabo\shared\infrastructure\doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    protected function persist($entityClass): void
    {
        $this->entityManager()->persist($entityClass);
        $this->entityManager()->flush($entityClass);
    }

    protected function remove($entityClass): void
    {
        $this->entityManager()->remove($entityClass);
        $this->entityManager()->flush($entityClass);
    }

    protected function repository($entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }

}