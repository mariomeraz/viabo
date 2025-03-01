<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\create_sub_account;

use Viabo\shared\domain\bus\query\Query;

final readonly class CardCloudSubAccountCreatorQuery implements Query
{
    public function __construct(public string $businessId, public string $companyId, public string $rfc)
    {
    }
}
