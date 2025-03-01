<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\application\find_companies_with_service_card_cloud_by_admin;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompaniesWithCardCloudServiceByAdminQueryHandler implements QueryHandler
{
    public function __construct(private CompaniesWithCardCloudServiceByAdminFinder $finder)
    {
    }

    public function __invoke(CompaniesWithCardCloudServiceByAdminQuery $query): Response
    {
        return $this->finder->__invoke($query->userId, $query->businessId, $query->profileId);
    }
}
