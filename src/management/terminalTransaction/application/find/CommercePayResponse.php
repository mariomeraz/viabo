<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\find;

use Viabo\shared\domain\bus\query\Response;

final readonly class CommercePayResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}
