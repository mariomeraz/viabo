<?php
declare(strict_types=1);

namespace Viabo\security\user\application\find_admin_users_company;

use Viabo\shared\domain\bus\query\Query;

final readonly class AdminUsersCompanyQuery implements Query
{
    public function __construct(public string $businessId) {
    }
}
