<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardOwnerId;
use Viabo\management\card\domain\CardRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardFinderByOwner
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardOwnerId $ownerId): CardResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'ownerId.value' , 'operator' => '=' , 'value' => $ownerId->value() ]
        ]);
        $card = $this->repository->searchCriteria(new Criteria($filter));

        return new CardResponse(array_map(function (Card $card){
            return $card->toArray();
        }, $card));
    }
}