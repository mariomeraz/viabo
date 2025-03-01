<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_service;


use Viabo\shared\domain\bus\query\Query;

final readonly class CompanyServiceQuery implements Query
{
    public function __construct(public string $companyId, public string $serviceId)
    {
    }
}