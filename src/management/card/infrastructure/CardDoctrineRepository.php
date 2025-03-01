<?php declare(strict_types=1);


namespace Viabo\management\card\infrastructure;


use Doctrine\ORM\EntityManager;
use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardInformationView;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\infrastructure\doctrine\DoctrineRepository;
use Viabo\shared\infrastructure\persistence\DoctrineCriteriaConverter;

final class CardDoctrineRepository extends DoctrineRepository implements CardRepository
{
    public function __construct(EntityManager $ManagementEntityManager)
    {
        parent::__construct($ManagementEntityManager);
    }

    public function save(Card $card): void
    {
        $this->persist($card);
    }

    public function search(string $cardId): Card|null
    {
        return $this->repository(Card::class)->find($cardId);
    }

    public function searchCriteria(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(Card::class)->matching($criteriaConvert)->toArray();
    }

    public function searchView(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CardView::class)->matching($criteriaConvert)->toArray();
    }

    public function searchAllView(): array
    {
        return $this->repository(CardView::class)->findAll();
    }

    public function searchCardInformationView(Criteria $criteria): array
    {
        $criteriaConvert = DoctrineCriteriaConverter::convert($criteria);
        return $this->repository(CardInformationView::class)->matching($criteriaConvert)->toArray();
    }

    public function update(Card $card): void
    {
        $this->entityManager()->flush($card);
    }
}
