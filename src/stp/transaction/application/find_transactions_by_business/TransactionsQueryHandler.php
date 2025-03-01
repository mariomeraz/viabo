<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_transactions_by_business;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TransactionsQueryHandler implements QueryHandler
{
    public function __construct(private TransactionsFinder $finder)
    {
    }

    public function __invoke(TransactionsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->initialDate,
            $query->endDate,
            $query->account,
            $query->limit
        );
    }
}