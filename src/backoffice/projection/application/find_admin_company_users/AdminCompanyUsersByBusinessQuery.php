<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\application\find_admin_company_users;

use Viabo\shared\domain\bus\query\Query;

final readonly class AdminCompanyUsersByBusinessQuery implements Query
{

    public function __construct(public string $businessId)
    {
    }
}
