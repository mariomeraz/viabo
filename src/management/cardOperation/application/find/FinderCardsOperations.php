<?php declare(strict_types=1);

namespace Viabo\management\cardOperation\application\find;

use Viabo\management\cardOperation\domain\CardOperation;
use Viabo\management\cardOperation\domain\CardOperationRepository;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\utils\DatePHP;

final readonly class FinderCardsOperations
{
    public function __construct(private CardOperationRepository $repository)
    {
    }

    public function __invoke(
        array       $cardsInformation ,
        string|null $initialDate ,
        string|null $finalDate
    ): CardsOperationsResponse
    {
        $this->ensureFormatDates($initialDate , $finalDate);
        $allOperations = [];
        foreach ($cardsInformation as $card) {
            $cardNumber = CardNumber::create($card['number']);

            $operations = $this->repository->searchDateRange($cardNumber , $initialDate , $finalDate);
            $cardOperation = array_map(function (CardOperation $operation) {
                $data = $operation->toArray();
                return [
                    'payTransactionId' => $data['payTransactionId'] ,
                    'descriptionPay' => $data['descriptionPay'] ,
                    'reverseTransactionId' => $data['reverseTransactionId'] ,
                    'descriptionReverse' => $data['descriptionReverse'] ,
                    'concept' => $data['concept']
                ];
            } , $operations);

            $allOperations = array_merge($allOperations , $cardOperation);
        }
        return new CardsOperationsResponse($allOperations);
    }

    private function ensureFormatDates(string $initialDate , string $finalDate): void
    {
        try {
            $date = new DatePHP();
            $date->formatDateTime($initialDate);
            $date->formatDateTime($finalDate);
        } catch (\Exception) {
            throw new \DomainException('No es un formato de fecha' , 400);
        }
    }
}
