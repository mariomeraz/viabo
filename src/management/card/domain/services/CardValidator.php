<?php declare(strict_types=1);


namespace Viabo\management\card\domain\services;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final class CardValidator
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function ensureNotExist(Card $card): void
    {
        $filters = Filters::fromValues([
            ['field' => 'number' , 'operator' => '=' , 'value' => $card->number()->value() ]
        ]);

        $card = $this->repository->searchCriteria(new Criteria($filters));

        if(!empty($card)){
            throw new CardExist();
        }
    }
}