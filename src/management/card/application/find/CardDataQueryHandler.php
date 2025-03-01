<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardDataQueryHandler implements QueryHandler
{
    public function __construct(private CardDataFinder $finder)
    {
    }

    public function __invoke(CardDataQuery $query): Response
    {
        $cardNumber = CardNumber::create($query->cardNumber);

        return $this->finder->__invoke($cardNumber);
    }
}