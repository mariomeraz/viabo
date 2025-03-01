<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\services\CardMovementsFinderOnSet;

final readonly class CardMovementsFinder
{

    public function __construct(private CardMovementsFinderOnSet $finderOnSet)
    {
    }

    public function __invoke(
        array  $card ,
        string $initialDate ,
        string $finalDate ,
        array  $operations
    ): CardMovementsResponse
    {
        $cardsMovements = $this->finderOnSet->__invoke(
            $card ,
            $initialDate ,
            $finalDate ,
            $operations
        );

        return new CardMovementsResponse($cardsMovements->toArray());
    }

}