<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\find;

use Viabo\shared\domain\bus\query\Response;

final readonly class TerminalConsolidationTransactionsResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}
