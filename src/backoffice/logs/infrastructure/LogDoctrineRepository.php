<?php declare(strict_types=1);


namespace Viabo\backoffice\logs\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\backoffice\logs\domain\Log;
use Viabo\backoffice\logs\domain\LogRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class LogDoctrineRepository extends DoctrineRepository implements LogRepository
{
    public function __construct(EntityManager $BackofficeEntityManager)
    {
        parent::__construct($BackofficeEntityManager);
    }

    public function save(Log $log): void
    {
        $this->persist($log);
    }
}