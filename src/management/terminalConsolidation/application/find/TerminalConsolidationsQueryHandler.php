<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TerminalConsolidationsQueryHandler implements QueryHandler
{
    public function __construct(private FinderTerminalConsolidationTransactions $finder)
    {
    }

    public function __invoke(TerminalConciliationsQuery $query): Response
    {
        return $this->finder->__invoke($query->terminals , $query->terminalId);
    }
}
