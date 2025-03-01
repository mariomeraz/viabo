<?php declare(strict_types=1);


namespace Viabo\stp\bank\application\find_bank_by_code;


use Viabo\shared\domain\bus\query\Query;

final readonly class BankQueryByCode implements Query
{
    public function __construct(public string $bankCode)
    {
    }
}