<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class VirtualTerminalsQueryHandler implements QueryHandler
{
    public function __construct(private VirtualTerminalsFinder $finder)
    {
    }

    public function __invoke(VirtualTerminalsQuery $query):Response
    {
        return $this->finder->__invoke($query->commerceId);
    }
}
