<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_stp_account_commissions;


use Viabo\shared\domain\bus\query\Query;

final readonly class StpAccountCommissionsQuery implements Query
{
    public function __construct(public string $businessId, public string $startDay, public string $endDay)
    {
    }
}