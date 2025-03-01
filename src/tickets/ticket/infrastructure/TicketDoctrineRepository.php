<?php declare(strict_types=1);


namespace Viabo\tickets\ticket\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;
use Viabo\tickets\ticket\domain\Ticket;
use Viabo\tickets\ticket\domain\TicketFile;
use Viabo\tickets\ticket\domain\TicketRepository;

final class TicketDoctrineRepository extends DoctrineRepository implements TicketRepository
{
    public function __construct(EntityManager $TicketsEntityManager)
    {
        parent::__construct($TicketsEntityManager);
    }

    public function save(Ticket $ticket): void
    {
        $this->persist($ticket);
    }

    public function search(string $ticketId): Ticket|null
    {
        return $this->repository(Ticket::class)->find($ticketId);
    }

    public function searchIdLast(): Ticket|null
    {
        return $this->repository(Ticket::class)->findOneBy([] , ['id.value' => 'desc']);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Ticket::class)->matching($criteriaConvert)->toArray();
    }

    public function update(Ticket $ticket): void
    {
        $this->entityManager()->flush($ticket);
    }
}