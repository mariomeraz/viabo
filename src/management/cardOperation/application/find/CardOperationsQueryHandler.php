<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\find;


use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardOperationsQueryHandler implements QueryHandler
{
    public function __construct(private CardOperationsFinder $finder)
    {
    }

    public function __invoke(CardOperationsQuery $query): Response
    {
        $cardNumber = CardNumber::create($query->cardNumber);
        return $this->finder->__invoke($cardNumber, $query->initialDate, $query->finalDate);
    }
}