<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\find;

use Viabo\shared\domain\bus\query\Query;

final readonly class TerminalsTransactionsQuery implements Query
{
    public function __construct(
        public string  $commerceId ,
        public string  $credentialApikey ,
        public string  $terminalId ,
        public array   $terminals ,
        public ?array  $conciliations ,
        public string  $startDate ,
        public string  $endDate ,
        public ?string $page ,
        public ?string $pageSize
    )
    {
    }
}
