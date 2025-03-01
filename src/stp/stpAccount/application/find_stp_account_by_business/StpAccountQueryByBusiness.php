<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_account_by_business;


use Viabo\shared\domain\bus\query\Query;

final readonly class StpAccountQueryByBusiness implements Query
{
    public function __construct(public string $businessId)
    {
    }
}