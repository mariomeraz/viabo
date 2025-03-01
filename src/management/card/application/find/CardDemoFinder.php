<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardDemoNotExist;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardDemoFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardNumber $cardNumber): CardResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'number' , 'operator' => 'ENDS_WITH' , 'value' => $cardNumber->value()]
        ]);
        $card = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($card)) {
            throw new CardDemoNotExist();
        }

        return new CardResponse([
            'cardId' => $card[0]->id()->value() ,
            'cardNumber' => $card[0]->number()->value()
        ]);
    }
}