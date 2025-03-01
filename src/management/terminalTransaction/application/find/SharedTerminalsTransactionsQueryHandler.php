<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SharedTerminalsTransactionsQueryHandler implements QueryHandler
{
    public function __construct(private SharedTerminalsTransactionsFinder $finder)
    {
    }

    public function __invoke(SharedTerminalsTransactionsQuery $query): Response
    {
        return $this->finder->__invoke(
            $query->commerceId ,
            $query->apiKey ,
            $query->terminals ,
            $query->startDate ,
            $query->endDate
        );
    }
}