<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\find;

use Viabo\management\shared\domain\commerce\CommerceId;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class TerminalConsolidationQueryHandler implements QueryHandler
{
    public function __construct(private FinderTerminalConsolidation $finder)
    {
    }

    public function __invoke(TerminalConsolidationQuery $query):Response
    {
        $commerceId = new CommerceId($query->commerceId);

        return $this->finder->__invoke($commerceId);
    }
}
