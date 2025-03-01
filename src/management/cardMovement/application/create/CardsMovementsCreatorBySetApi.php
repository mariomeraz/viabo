<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\application\create;


use Viabo\management\cardMovement\domain\CardMovement;
use Viabo\management\cardMovement\domain\CardMovementLog;
use Viabo\management\cardMovement\domain\CardMovementRepository;
use Viabo\management\cardMovement\domain\CardMovements;
use Viabo\management\cardMovement\domain\services\CardMovementFinder;
use Viabo\management\cardMovement\domain\services\CardMovementsFinderOnSet;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;
use Viabo\shared\domain\utils\DatePHP;

final readonly class CardsMovementsCreatorBySetApi
{
    public function __construct(
        private CardMovementRepository   $repository ,
        private CardMovementsFinderOnSet $finderOnSet ,
        private CardMovementFinder       $finder ,
        private DatePHP                  $datePHP
    )
    {
    }

    public function __invoke(
        array  $cards ,
        array  $cardsOperations ,
        string $startDate ,
        string $endDate ,
        bool   $today
    ): void
    {
        $startDate = $this->formatStartDate($startDate, $today);
        $endDate = $this->formatEndDate($endDate , $startDate, $today);

        foreach ($cards as $card) {
            try {
                $cardMovementsOnSetApi = $this->finderOnSet->__invoke(
                    $card ,
                    $startDate ,
                    $endDate,
                    $cardsOperations
                );
                $this->save($cardMovementsOnSetApi);
            } catch (\Exception $exception) {
                $this->repository->saveLog(CardMovementLog::create($card['id'] , $exception->getMessage()));
            }
        }

    }

    private function formatStartDate(string $startDate, bool $today): string
    {
        if($today){
            return "{$this->datePHP->now()} 00:00:00";
        }
        if (empty($startDate)) {
            return '2023-01-01 00:00:00';
        }

        if (!$this->datePHP->hasFormatDateTime($startDate)) {
            return "$startDate 00:00:00";
        }

        return $startDate;
    }

    private function formatEndDate(string $endDate , string $startDate, bool $today): string
    {
        if($today){
            return "{$this->datePHP->now()} 23:59:59";
        }

        if (empty($endDate) && !empty($startDate)) {
            return $this->datePHP->dateTime();
        }

        if (!$this->datePHP->hasFormatDateTime($endDate) && !empty($startDate)) {
            return "$endDate 23:59:59";
        }

        return $endDate;
    }

    private function save(CardMovements $cardMovementsOnSetApi): void
    {
        array_map(function (CardMovement $cardMovement) {
            if ($this->hasNotRegistered($cardMovement->transactionId())) {
                $this->repository->save($cardMovement);
            }
        } , $cardMovementsOnSetApi->movements());
    }

    private function hasNotRegistered(string $transactionId): bool
    {
        try {
            $filters = Filters::fromValues([
                ['field' => 'setTransactionId.value' , 'operator' => '=' , 'value' => $transactionId]
            ]);
            $this->finder->__invoke(new Criteria($filters));
            return false;
        } catch (\DomainException) {
            return true;
        }
    }
}
