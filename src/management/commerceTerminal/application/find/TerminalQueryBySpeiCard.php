<?php declare(strict_types=1);

namespace Viabo\management\commerceTerminal\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class TerminalQueryBySpeiCard implements Query
{
    public function __construct(public string $terminalId)
    {
    }
}
