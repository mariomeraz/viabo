<?php declare(strict_types=1);


namespace Viabo\management\card\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final class StockCardsQueryHandler implements QueryHandler
{
    public function __construct(private StockCardsFinder $finder)
    {
    }

    public function __invoke(StockCardsQuery $query): Response
    {
        return ($this->finder)();
    }
}