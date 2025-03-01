<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\shared\domain\bus\query\Response;
use Viabo\shared\domain\bus\query\QueryHandler;

final readonly class TerminalsQueryHandler implements QueryHandler
{
    public function __construct(private TerminalsFinder $finder)
    {
    }

    public function __invoke(TerminalsQuery $query):Response
    {
        return $this->finder->__invoke($query->commerceId);
    }
}
