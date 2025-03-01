<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_services_by_user;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompanyServicesTypeIdQueryByUser implements Query
{
    public function __construct(public string $userId, public string $profileId, public string $businessId)
    {
    }
}