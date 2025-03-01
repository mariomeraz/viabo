<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class TransactionUrlQuery implements Query
{
    public function __construct(public string $transactionId)
    {
    }
}