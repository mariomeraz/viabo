<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_statement_account;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StatementAccountQueryHandler implements QueryHandler
{
    public function __construct(private StatementAccountFinder $finder)
    {
    }

    public function __invoke(StatementAccountQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->accountNumber,
            $query->month,
            $query->year
        );
    }
}