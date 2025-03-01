<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class FinishedFundingOrderQueryHandler implements QueryHandler
{
    public function __construct(private FinishedFundingOrderFinder $finder)
    {
    }

    public function __invoke(FinishedFundingOrderQuery $query): Response
    {
        $cardId = CardId::create($query->cardId);

        return $this->finder->__invoke($cardId);
    }
}