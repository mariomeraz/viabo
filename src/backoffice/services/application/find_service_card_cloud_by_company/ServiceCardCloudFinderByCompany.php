<?php declare(strict_types=1);


namespace Viabo\backoffice\services\application\find_service_card_cloud_by_company;


use Viabo\backoffice\services\application\ServiceResponse;
use Viabo\backoffice\services\domain\services\find_service_by_criteria\ServiceFinderByCriteria;

final readonly class ServiceCardCloudFinderByCompany
{
    public function __construct(private ServiceFinderByCriteria $serviceFinder)
    {
    }

    public function __invoke(string $companyId): ServiceResponse
    {
        $filters = [['field' => 'companyId', 'operator' => '=', 'value' => $companyId]];
        $service = $this->serviceFinder->__invoke($filters, '4');

        return new ServiceResponse($service->toArray());
    }
}