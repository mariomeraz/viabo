<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class OwnerCardsFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(): CardsResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'ownerId.value' , 'operator' => '<>' , 'value' => ''] ,
            ['field' => 'main.value' , 'operator' => '=' , 'value' => '0'] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);
        $cards = $this->repository->searchCriteria(new Criteria($filters));

        return new CardsResponse(array_map(function (Card $card) {
            $data = $card->toArray();
            return [
                'id' => $data['id'],
                'number' => $data['number'],
                'ownerId' => $data['ownerId']
            ];
        } , $cards));
    }
}