<?php declare(strict_types=1);

namespace Viabo\backoffice\projection\application\find_admin_company_users;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AdminCompanyUsersByBusinessQueryHandler implements QueryHandler
{
    public function __construct(private AdminCompanyUsersByBusinessFinder $finder)
    {
    }

    public function __invoke(AdminCompanyUsersByBusinessQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId);
    }

}
