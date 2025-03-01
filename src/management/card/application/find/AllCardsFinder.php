<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\card\domain\CardRepository;
use Viabo\management\card\domain\CardView;

final readonly class AllCardsFinder
{
    public function __construct(private CardRepository $repository)
    {
    }

    public function __invoke(): CardsResponse
    {
        $cards = $this->repository->searchAllView();
        return new CardsResponse(array_map(function (CardView $card){
            return $card->toArray();
        }, $cards));
    }
}