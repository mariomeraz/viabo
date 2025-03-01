<?php declare(strict_types=1);


namespace Viabo\security\user\application\find_companies_admins_by_business;


use Viabo\shared\domain\bus\query\Query;

final readonly class AdministratorsOfCompaniesQuery implements Query
{
    public function __construct(public string $businessId)
    {
    }
}