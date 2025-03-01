<?php declare(strict_types=1);


namespace Viabo\backoffice\fee\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\fee\domain\Fee;
use Viabo\backoffice\fee\domain\FeeRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class FeeDoctrineRepository extends DoctrineRepository implements FeeRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function searchAll(): array
    {
        return $this->repository(Fee::class)->findAll();
    }
}