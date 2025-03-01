<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardDemoQueryHandler implements QueryHandler
{
    public function __construct(private CardDemoFinder $finder)
    {
    }

    public function __invoke(CardDemoQuery $query): Response
    {
        $cardNumber = CardNumber::createLast8Digits($query->cardNumber);
        return $this->finder->__invoke($cardNumber);
    }
}