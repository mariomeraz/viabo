<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account;


use Viabo\shared\domain\bus\query\Query;

final readonly class StatementAccountQuery implements Query
{
    public function __construct(
        public int $accountNumber,
        public int $month,
        public int $year
    )
    {
    }
}