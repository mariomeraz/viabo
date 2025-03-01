<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\find_service_card_cloud_by_company;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class ServiceCardCloudQueryHandlerByCompany implements QueryHandler
{
    public function __construct(private ServiceCardCloudFinderByCompany $finder)
    {
    }

    public function __invoke(ServiceCardCloudQueryByCompany $query): Response
    {
        return $this->finder->__invoke($query->companyId);
    }
}