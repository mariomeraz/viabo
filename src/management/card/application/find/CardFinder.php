<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\exceptions\CardNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(string $cardId): CardResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'id' , 'operator' => '=' , 'value' => $cardId]
        ]);
        $card = $this->repository->searchView(new Criteria($filter));

        if (empty($card)) {
            throw new CardNotExist();
        }

        return new CardResponse($card[0]->toArray());
    }
}