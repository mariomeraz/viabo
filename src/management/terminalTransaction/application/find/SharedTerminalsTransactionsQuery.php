<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class SharedTerminalsTransactionsQuery implements Query
{
    public function __construct(
        public string $commerceId ,
        public string $apiKey ,
        public array  $terminals ,
        public string $startDate ,
        public string $endDate
    )
    {
    }
}