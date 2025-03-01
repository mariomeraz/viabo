<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_transactions_balance;


use Viabo\shared\domain\bus\query\Query;

final readonly class TransactionsBalanceQuery implements Query
{
    public function __construct(
        public string $businessId,
        public string $initialDate,
        public string $endDate,
        public string $account
    )
    {
    }
}