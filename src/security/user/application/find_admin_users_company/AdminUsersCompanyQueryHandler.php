<?php declare(strict_types=1);

namespace Viabo\security\user\application\find_admin_users_company;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class AdminUsersCompanyQueryHandler implements QueryHandler
{
    public function __construct(private AdminUsersCompanyFinder $finder)
    {
    }

    public function __invoke(AdminUsersCompanyQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId);
    }

}
