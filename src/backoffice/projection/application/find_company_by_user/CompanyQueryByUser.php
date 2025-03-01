<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_by_user;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompanyQueryByUser implements Query
{
    public function __construct(public string $userId, public string $businessId, public string $profileId)
    {
    }
}