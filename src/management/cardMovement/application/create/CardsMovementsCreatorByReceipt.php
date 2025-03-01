<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\create;


use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\CardMovementRepository;
use Viabo\management\cardMovement\domain\CardMovements;
use Viabo\management\cardMovement\domain\services\CardMovementFinderByTransactionId;
use Viabo\management\cardMovement\domain\services\EnsureMovements;


final readonly class CardsMovementsCreatorByReceipt
{
    public function __construct(
        private CardMovementRepository            $repository ,
        private CardMovementFinderByTransactionId $finder ,
        private EnsureMovements                   $ensureMovements
    )
    {
    }

    public function __invoke(string $receiptId , array $cardsMovements): void
    {
        $cardsMovements = CardMovements::fromValues($cardsMovements);
        $this->ensureMovements->__invoke($cardsMovements , $receiptId);
        $cardsMovements->addReceiptIdToMovements($receiptId);
        $this->save($cardsMovements);
    }

    private function save(CardMovements $cardMovements): void
    {
        array_map(function (CardMovement $cardMovement) {
            $this->ensureNotExist($cardMovement);
            $this->repository->save($cardMovement);
        } , $cardMovements->movements());
    }

    private function ensureNotExist(CardMovement $cardMovement): void
    {
        try {
            $movement = $this->finder->__invoke($cardMovement->transactionId());
            $this->repository->delete($movement);
        } catch (\DomainException) {
        }
    }

}
