<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class CommerceTransactionQuery implements Query
{
    public function __construct(public string $transactionId)
    {
    }
}
