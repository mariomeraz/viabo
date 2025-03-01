<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TerminalTransactionQueryHandler implements QueryHandler
{
    public function __construct(private TerminalTransactionFinder $finder)
    {
    }

    public function __invoke(TerminalTransactionQuery $query): Response
    {
        return $this->finder->__invoke($query->terminalTransactionId);
    }
}