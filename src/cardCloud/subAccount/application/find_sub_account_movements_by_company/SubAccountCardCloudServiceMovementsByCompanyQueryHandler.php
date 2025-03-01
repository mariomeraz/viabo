<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\find_sub_account_movements_by_company;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SubAccountCardCloudServiceMovementsByCompanyQueryHandler implements QueryHandler
{
    public function __construct(private SubAccountCardCloudServiceMovementsByCompanyFinder $finder)
    {
    }

    public function __invoke(SubAccountCardCloudServiceMovementsByCompanyQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->subAccountId, $query->fromDate, $query->toDate);
    }
}
