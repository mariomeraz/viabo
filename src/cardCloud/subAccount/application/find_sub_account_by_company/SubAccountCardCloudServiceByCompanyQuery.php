<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\find_sub_account_by_company;

use Viabo\shared\domain\bus\query\Query;

final readonly class SubAccountCardCloudServiceByCompanyQuery implements Query
{
    public function __construct(public string $businessId, public string $subAccountId)
    {
    }
}
