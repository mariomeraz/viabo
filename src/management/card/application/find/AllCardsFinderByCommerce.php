<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class AllCardsFinderByCommerce
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(string $commerceId): CardsResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'commerceId' , 'operator' => '=' , 'value' => $commerceId] ,
            ['field' => 'active' , 'operator' => '=' , 'value' => '1']
        ]);
        $cards = $this->repository->searchView(new Criteria($filters));

        return new CardsResponse(array_map(function (CardView $card) {
            return $card->toArray();
        } , $cards));
    }
}