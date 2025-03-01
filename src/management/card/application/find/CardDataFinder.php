<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\services\CardFinder as CardFinderService;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardDataFinder
{
    public function __construct(private CardFinderService $finder )
    {
    }

    public function __invoke(CardNumber $cardNumber): CardResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'number' , 'operator' => '=' , 'value' => $cardNumber->value() ]
        ]);

        $card = $this->finder->searchCriteria(new Criteria($filter));

        return new CardResponse($card->toArray());
    }
}