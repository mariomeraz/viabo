<?php declare(strict_types=1);

namespace Viabo\management\cardMovement\application\find;

use Viabo\management\cardMovement\domain\services\CardMovementsFinderOnSet;
use Viabo\shared\domain\utils\DatePHP;

final readonly class MasterCardsMovementsFinder
{
    public function __construct( private CardMovementsFinderOnSet $finder)
    {
    }

    public function __invoke(
        array  $cards ,
        array  $operations ,
        array  $payTransactions ,
        string $initialDate ,
        string $finalDate
    ): CardsMovementsResponse
    {
        if (!empty($payTransactions)) {
            $payTransactions = $this->payTransactionsApproved($payTransactions['movements']);
        }
        $cardsMovements = $this->searchCardsMovements(
            $cards ,
            $initialDate ,
            $finalDate ,
            $operations
        );
        return new CardsMovementsResponse(array_merge($cardsMovements , $payTransactions));
    }

    private function payTransactionsApproved(array $payTransactions): array
    {
        $data = array_map(function (array $transaction) {
            $description = "{$transaction['result_message']} en {$transaction['terminal_name']}";
            $date = new DatePHP();

            return [
                'date' => $date->formatDateTime($transaction['transaction_date']) ,
                'description' => $description ,
                'concept' => '' ,
                'amount' => $transaction['amount'] ,
                'type' => "Terminal" ,
                'operationType' => "VIABO PAY" ,
                'cardPaymentProcessor' => "Terminal" ,
            ];
        } , array_filter($payTransactions , function (array $payTransactionsData) {
            return $payTransactionsData['approved'];
        }));

        return array_values($data);
    }

    private function searchCardsMovements(
        array  $cards ,
        string $initialDate ,
        string $finalDate ,
        array  $operations
    ): array
    {
        $allMovements = [];
        foreach ($cards as $card) {
            $cardMovements = $this->finder->__invoke(
                $card ,
                $initialDate ,
                $finalDate ,
                $operations
            );
            $allMovements = array_merge($allMovements , $cardMovements->toArray());
        }
        return $allMovements;
    }
}
