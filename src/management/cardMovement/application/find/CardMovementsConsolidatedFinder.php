<?php declare(strict_types=1);

namespace Viabo\management\cardMovement\application\find;

use Viabo\management\cardMovement\domain\services\CardMovementsFinderOnSet;
use Viabo\shared\domain\Utils;
use Viabo\shared\domain\utils\DatePHP;

final readonly class CardMovementsConsolidatedFinder
{
    public function __construct(
        private CardMovementsFinderOnSet $finder ,
        private DatePHP                  $datePHP
    )
    {
    }

    public function __invoke(
        string $startDate ,
        array  $card ,
        ?array $movementsConciliated
    ): CardMovementsConsolidatedResponse
    {
        $mainCardTransactionsId = $this->filterTransactionsIds($movementsConciliated);
        $cardMovements = $this->finder->__invoke(
            $card ,
            $startDate ,
            $this->datePHP->dateTime()
        );
        $cardMovements = $this->filterConciliatedMovements($cardMovements->toArray() , $mainCardTransactionsId);

        return new CardMovementsConsolidatedResponse($cardMovements);
    }


    private function filterTransactionsIds(?array $movementsConciliated): array
    {
        $transactionsIds = array_map(function (array $movementConciliated) {
            return $movementConciliated['speiCardTransactionId'];
        } , $movementsConciliated);

        return Utils::removeDuplicateElements($transactionsIds);
    }

    private function filterConciliatedMovements(array $cardMovements , array $mainCardTransactionsId): array
    {
        return array_filter($cardMovements , function (array $carMovement) use ($mainCardTransactionsId) {
            return !in_array($carMovement['transactionId'] , $mainCardTransactionsId);
        });
    }
}
