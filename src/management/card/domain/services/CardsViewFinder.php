<?php declare(strict_types=1);


namespace Viabo\management\card\domain\services;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\Cards;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardsViewFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function searchCriteria(Filters $filters): Cards
    {
        $cards = $this->repository->searchView(new Criteria($filters));
        return new Cards($cards);
    }
}