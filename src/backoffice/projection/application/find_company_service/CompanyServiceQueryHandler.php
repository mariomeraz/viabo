<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_company_service;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompanyServiceQueryHandler implements QueryHandler
{
    public function __construct(private CompanyServiceFinder $finder)
    {
    }

    public function __invoke(CompanyServiceQuery $query): Response
    {
        return $this->finder->__invoke($query->companyId, $query->serviceId);
    }
}