<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class BalanceInTransactionQueryHandler implements QueryHandler
{
    public function __construct(private BalanceInTransactionFinder $finder)
    {
    }

    public function __invoke(BalanceInTransactionQuery $query): Response
    {
        return $this->finder->__invoke($query->cardsNumber);
    }
}