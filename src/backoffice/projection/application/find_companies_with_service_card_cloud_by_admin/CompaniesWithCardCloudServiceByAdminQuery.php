<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\application\find_companies_with_service_card_cloud_by_admin;

use Viabo\shared\domain\bus\query\Query;

final readonly class CompaniesWithCardCloudServiceByAdminQuery implements Query
{

    public function __construct(public string $userId, public string $businessId, public string $profileId)
    {
    }
}
