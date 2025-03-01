<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\find_service_card_cloud_by_company;


use Viabo\shared\domain\bus\query\Query;

final readonly class ServiceCardCloudQueryByCompany implements Query
{
    public function __construct(public string $companyId)
    {
    }
}