<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_transactions_balance;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TransactionsBalanceQueryHandler implements QueryHandler
{
    public function __construct(private TransactionsBalanceFinder $finder)
    {
    }

    public function __invoke(TransactionsBalanceQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->businessId,
            $query->initialDate,
            $query->endDate,
            $query->account
        );
    }
}