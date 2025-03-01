<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\find;


use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;
use Viabo\shared\domain\utils\DatePHP;

final readonly class TodayCardsOperationsQueryHandler implements QueryHandler
{
    public function __construct(private CardOperationsFinder $finder , private DatePHP $date)
    {
    }

    public function __invoke(AddTodayCardsOperationsQuery $query): Response
    {
        return new CardOperationsResponse(array_map(function (array $card) {
            $cardNumber = CardNumber::create($card['number']);
            $operation = $this->finder->__invoke($cardNumber , $this->date->now() , "{$this->date->now()} 23:59:59");
            $card['operationData'] = $operation->data;
            return $card;
        } , $query->cards));
    }
}