<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find;


use Viabo\shared\domain\bus\query\Query;

final readonly class StpAccountQueryByCompany implements Query
{
    public function __construct(public string $company, public bool $stpAccountsDisable)
    {
    }
}