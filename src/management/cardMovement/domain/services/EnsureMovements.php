<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\services;


use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\CardMovements;
use Viabo\management\cardMovement\domain\events\FailureToCreateCardsMovementsDomainEvent;
use Viabo\management\cardMovement\domain\exceptions\CardMovementChecked;
use Viabo\management\cardMovement\domain\exceptions\CardMovementOperationTypeNotAllowed;
use Viabo\management\cardMovement\domain\exceptions\CardsMovementsEmpty;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class EnsureMovements
{
    public function __construct(private EventBus $bus)
    {
    }

    public function __invoke(CardMovements $cardMovements , string $receiptId): void
    {
        try {
            $this->ensureMovementsNoEmpty($cardMovements);
            $this->ensureMovementsIsNotChecked($cardMovements);
            $this->ensureMovementsOfExternalCharges($cardMovements);
        } catch (\DomainException $exception) {
            $this->bus->publish(...[new FailureToCreateCardsMovementsDomainEvent($receiptId , [])]);
            throw new \DomainException($exception->getMessage() , $exception->getCode());
        }
    }

    private function ensureMovementsNoEmpty(CardMovements $movements): void
    {
        if (empty($movements->count())) {
            throw new CardsMovementsEmpty();
        }
    }

    private function ensureMovementsIsNotChecked(CardMovements $movements): void
    {
        array_map(function (CardMovement $cardMovement) {
            if ($cardMovement->hasReceipt()) {
                throw new CardMovementChecked($cardMovement->cardNumber());
            }
        } , $movements->movements());
    }

    private function ensureMovementsOfExternalCharges(CardMovements $movements): void
    {
        array_map(function (CardMovement $movement) {
            if ($movement->isNotOperationTypeExternalCharge()) {
                throw new CardMovementOperationTypeNotAllowed();
            }
        } , $movements->movements());
    }

}