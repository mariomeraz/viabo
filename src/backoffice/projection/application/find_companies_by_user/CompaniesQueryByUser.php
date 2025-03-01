<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_by_user;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompaniesQueryByUser implements Query
{
    public function __construct(public string $userId, public string $businessId)
    {
    }
}