<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final class StockCardsFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(): StockCardsResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => '' ],
            ['field' => 'ownerId' , 'operator' => '=' , 'value' => '' ],
            ['field' => 'active' , 'operator' => '=' , 'value' => '1' ]
        ]);

        $cards = $this->repository->searchView(new Criteria($filters));

        return new StockCardsResponse(array_map(function(CardView $card){
            return $card->toArray();
        },$cards));
    }
}