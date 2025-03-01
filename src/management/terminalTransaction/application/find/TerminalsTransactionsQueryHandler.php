<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TerminalsTransactionsQueryHandler implements QueryHandler
{
    public function __construct(private TerminalsTransactionFinder $finder)
    {
    }

    public function __invoke(TerminalsTransactionsQuery $query): Response
    {

        return $this->finder->__invoke(
            $query->commerceId ,
            $query->credentialApikey ,
            $query->terminalId ,
            $query->terminals ,
            $query->conciliations ,
            "$query->startDate 00:00:00" ,
            "$query->endDate 23:59:59" ,
            $query->page ,
            $query->pageSize
        );

    }
}
