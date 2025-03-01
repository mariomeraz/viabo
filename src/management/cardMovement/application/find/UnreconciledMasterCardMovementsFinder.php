<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\find;


use Viabo\management\cardMovement\domain\services\CardMovementsFinderOnSet;
use Viabo\shared\domain\Utils;
use Viabo\shared\domain\utils\DatePHP;

final readonly class UnreconciledMasterCardMovementsFinder
{
    public function __construct(
        private CardMovementsFinderOnSet $finder ,
        private DatePHP                  $datePHP
    )
    {
    }

    public function __invoke(
        array  $card ,
        string $initialDate ,
        string $anchoringOrderAmount ,
        float  $threshold ,
        array  $conciliation ,
        array  $cardOperations
    ): CardMovementsResponse
    {
        $movements = $this->finder->__invoke(
            $card ,
            $initialDate ,
            $this->datePHP->dateTime() ,
            $cardOperations
        );
        $movements = $this->removeExpenseTypeMovements($movements->toArray());
        $movements = $this->removeMovementsAlreadyReconciled($movements , $conciliation);
        $movements = $this->removeMovementsThatAreNotInThreshold($movements , $threshold , $anchoringOrderAmount);

        return new CardMovementsResponse($movements);
    }

    private function removeExpenseTypeMovements(array $movements): array
    {
        return array_filter($movements , function (array $movement) {
            return $movement['type'] !== 'Gasto';
        });
    }

    private function removeMovementsAlreadyReconciled(array $movements , array $conciliation): array
    {
        if (empty($conciliation)) {
            return $movements;
        }

        $movements = array_filter($movements , function (array $movement) use ($conciliation) {
            foreach ($conciliation as $value) {
                return $value['conciliationNumber'] !== $movement['transactionId'];
            }
        });

        return Utils::removeDuplicateElements($movements);
    }

    private function removeMovementsThatAreNotInThreshold(
        array  $movements ,
        float  $threshold ,
        string $anchoringOrderAmount
    ): array
    {
        $anchoringOrderAmount = empty($anchoringOrderAmount) ? 0 : $anchoringOrderAmount;
        $minimumAmount = $anchoringOrderAmount - ($anchoringOrderAmount * ($threshold / 100));
        $movements = array_filter($movements , function (array $movement) use ($minimumAmount , $anchoringOrderAmount) {
            return $movement['amount'] >= $minimumAmount && $movement['amount'] <= $anchoringOrderAmount;
        });

        return Utils::removeDuplicateElements($movements);
    }
}