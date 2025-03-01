<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardCommerceIdEmpty;
use Viabo\management\card\domain\exceptions\CardNotExist;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardFinderByNumber
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(CardNumber $cardNumber): CardResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'number' , 'operator' => 'END_WITH' , 'value' => $cardNumber->value()]
        ]);

        $card = $this->repository->searchView(new Criteria($filter));

        if (empty($card)) {
            throw new CardNotExist();
        }

        $card = $card[0]->toArray();
        if (empty($card['commerceId'])) {
            throw new CardCommerceIdEmpty();
        }

        return new CardResponse($card);
    }
}