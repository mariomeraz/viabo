<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_accounts;


use Viabo\shared\domain\bus\query\Query;

final readonly class StpAccountsQuery implements Query
{
    public function __construct(public bool $stpAccountsDisable)
    {
    }
}