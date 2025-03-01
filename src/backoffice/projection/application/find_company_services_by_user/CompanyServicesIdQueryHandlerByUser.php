<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_services_by_user;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompanyServicesIdQueryHandlerByUser implements QueryHandler
{
    public function __construct(private CompanyServicesIdFinderByUser $finder)
    {
    }

    public function __invoke(CompanyServicesTypeIdQueryByUser $query): Response
    {
        return  $this->finder->__invoke($query->userId,$query->profileId, $query->businessId);
    }
}