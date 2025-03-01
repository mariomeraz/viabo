<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class CommercePayQueryByUrlCode implements Query
{
    public function __construct(public string $urlCode)
    {
    }
}
