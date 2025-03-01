<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\find;

use Viabo\shared\domain\bus\query\Response;

final readonly class CommerceTransactionResponse implements Response
{
    public function __construct(public array $data)
    {
    }
}
