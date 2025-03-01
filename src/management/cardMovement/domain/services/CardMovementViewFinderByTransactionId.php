<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\services;


use Viabo\management\cardMovement\domain\CardMovementRepository;
use Viabo\management\cardMovement\domain\CardMovementView;
use Viabo\management\cardMovement\domain\exceptions\CardMovementNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class CardMovementViewFinderByTransactionId
{
    public function __construct(private CardMovementRepository $repository)
    {
    }

    public function __invoke(string $transactionId): CardMovementView
    {
        $filter = Filters::fromValues([
            ['field' => 'SetTransactionId' , 'operator' => '=', 'value' => $transactionId]
        ]);

        $cardMovement = $this->repository->matchingView(new Criteria($filter));

        if (empty($cardMovement)) {
            throw new CardMovementNotExist();
        }

        return $cardMovement[0];
    }
}
