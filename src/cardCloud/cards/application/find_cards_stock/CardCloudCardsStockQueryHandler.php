<?php declare(strict_types=1);


namespace Viabo\cardCloud\cards\application\find_cards_stock;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CardCloudCardsStockQueryHandler implements QueryHandler
{
    public function __construct(private CardCloudCardsStockFinder $finder)
    {
    }

    public function __invoke(CardCloudCardsStockQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId);
    }
}