<?php declare(strict_types=1);


namespace Viabo\tickets\status\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\tickets\status\domain\Status;
use Viabo\tickets\status\domain\StatusRepository;

final class StatusDoctrineRepository extends DoctrineRepository implements StatusRepository
{
    public function __construct(EntityManager $TicketsEntityManager)
    {
        parent::__construct($TicketsEntityManager);
    }

    public function search(string $statusId): Status|null
    {
        return $this->repository(Status::class)->find($statusId);
    }
}