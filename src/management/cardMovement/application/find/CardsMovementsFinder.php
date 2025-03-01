<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\management\cardMovement\domain\CardMovementRepository;
use Viabo\management\cardMovement\domain\CardMovementView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardsMovementsFinder
{
    public function __construct(private CardMovementRepository $repository)
    {
    }

    public function __invoke(array $cards , array $filters): CardsMovementsResponse
    {
        $filters = $this->addFilterCards($cards, $filters);
        $filters = Filters::fromValues($filters);
        $cardMovements = $this->repository->matchingView(new Criteria($filters));

        return new CardsMovementsResponse(array_map(function (CardMovementView $movement) {
            return $movement->toArray();
        } , $cardMovements));
    }

    private function addFilterCards(array $cards, array $filters): array
    {
        $cardsIds = $this->getCardsIds($cards);
        return array_merge(
            $filters ,
            [['field' => 'cardId' , 'operator' => 'IN' , 'value' => implode(',' , $cardsIds)]]
        );
    }

    private function getCardsIds(array $cards): array
    {
        return array_map(function (array $card) {
            return $card['id'];
        } , $cards);
    }
}