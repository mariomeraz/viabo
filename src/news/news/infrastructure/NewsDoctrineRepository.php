<?php declare(strict_types=1);


namespace Viabo\news\news\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\news\news\domain\News;
use Viabo\news\news\domain\NewsRepository;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;

final class NewsDoctrineRepository extends DoctrineRepository implements NewsRepository
{
    public function __construct(EntityManager $NewsEntityManager)
    {
        parent::__construct($NewsEntityManager);
    }

    public function searchActives(): array
    {
        $query = "SELECT * FROM v_news where active = 1";
        $statement = $this->entityManager()->getConnection()->prepare($query);

        return $statement->executeQuery()->fetchAllAssociative();
    }
}