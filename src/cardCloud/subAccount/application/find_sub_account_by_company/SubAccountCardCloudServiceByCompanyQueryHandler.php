<?php declare(strict_types=1);

namespace Viabo\cardCloud\subAccount\application\find_sub_account_by_company;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class SubAccountCardCloudServiceByCompanyQueryHandler implements QueryHandler
{
    public function __construct(private SubAccountCardCloudServiceByCompanyFinder $finder)
    {
    }

    public function __invoke(SubAccountCardCloudServiceByCompanyQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->subAccountId);
    }

}
