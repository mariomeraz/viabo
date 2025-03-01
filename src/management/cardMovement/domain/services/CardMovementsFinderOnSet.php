<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain\services;


use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\CardMovementFilter;
use Viabo\management\cardMovement\domain\CardMovements;
use Viabo\management\shared\domain\paymentProcessor\PaymentProcessorAdapter;

final readonly class CardMovementsFinderOnSet
{
    public function __construct(
        private PaymentProcessorAdapter               $adapter ,
        private CardMovementViewFinderByTransactionId $finderByTransactionId
    )
    {
    }

    public function __invoke(
        array  $card ,
        string $startDate ,
        string $endDate ,
        array  $operations = []
    ): CardMovements
    {
        $filter = CardMovementFilter::create(
            $card['number'] ,
            $card['clientKey'] ,
            $startDate ,
            $endDate
        );
        $cardMovements = $this->adapter->searchMovements($filter);
        $cardMovements = empty($cardMovements) ? [] : $cardMovements['TicketMessage'];
        $cardMovements = $this->formatMovements($cardMovements , $card , $operations);
        return new CardMovements($cardMovements);
    }

    private function formatMovements(array $cardMovements , array $card , array $operations): array
    {
        return array_map(function (array $movementData) use ($card , $operations) {
            $receiptData = $this->searchReceiptBy($movementData['Auth_Code']);
            return CardMovement::fromSetApiValue(
                $card['id'] ,
                $card['number'] ,
                $card['paymentProcessor'] ?? $card['paymentProcessorName'] ,
                $card['commerceId'] ,
                $receiptData['receiptId'] ,
                $receiptData['receiptFiles'] ,
                $movementData ,
                $operations
            );
        } , array_filter($cardMovements , function (array $movementData) {
            return !empty($movementData['Transaction_Id']);
        }));
    }

    private function searchReceiptBy(string $transactionId): array
    {
        try {
            $cardMovement = $this->finderByTransactionId->__invoke($transactionId);
            return $cardMovement->toArray();
        } catch (\DomainException) {
            return ["receiptId" => '' , "receiptFiles" => ''];
        }
    }
}
