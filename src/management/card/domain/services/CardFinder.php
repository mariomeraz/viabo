<?php declare(strict_types=1);


namespace Viabo\management\card\domain\services;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardNotExist;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\criteria\Criteria;

final readonly class CardFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardId $cardId): Card
    {
        $card = $this->repository->search($cardId->value());

        if(empty($card)){
            throw new CardNotExist();
        }

        return $card;
    }

    public function searchCriteria(Criteria $criteria): Card
    {
        $card = $this->repository->searchCriteria($criteria);

        if(empty($card)){
            throw new CardNotExist();
        }

        return $card[0];
    }
}