<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_admin_cost_centers;


use Viabo\shared\domain\bus\query\Query;

final readonly class CostCenterAdminsQuery implements Query
{
    public function __construct(public string $businessId)
    {
    }
}