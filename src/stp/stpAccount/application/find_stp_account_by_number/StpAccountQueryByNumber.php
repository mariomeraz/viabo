<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_account_by_number;


use Viabo\shared\domain\bus\query\Query;

final readonly class StpAccountQueryByNumber implements Query
{
    public function __construct(public string $stpNumber, public string $businessId = '')
    {
    }
}