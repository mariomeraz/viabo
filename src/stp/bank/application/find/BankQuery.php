<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class BankQuery implements Query
{
    public function __construct(public string $bankId)
    {
    }
}