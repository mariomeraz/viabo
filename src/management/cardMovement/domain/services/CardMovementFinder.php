<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\services;


use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\CardMovementRepository;
use Viabo\management\cardMovement\domain\exceptions\CardMovementNotExist;
use Viabo\shared\domain\criteria\Criteria;

final readonly class CardMovementFinder
{
    public function __construct(private CardMovementRepository $repository)
    {
    }

    public function __invoke(Criteria $criteria): CardMovement
    {
        $cardMovement = $this->repository->matching($criteria);

        if (empty($cardMovement)) {
            throw new CardMovementNotExist();
        }

        return $cardMovement[0];
    }
}