<?php declare(strict_types=1);


namespace Viabo\backoffice\projection\application\find_companies_by_user;


use Viabo\backoffice\projection\application\find_company_by_criteria\CompanyProjectionCriteriaFinder;
use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompaniesQueryHandlerByAdminUser implements QueryHandler
{
    public function __construct(private CompanyProjectionCriteriaFinder $finder)
    {
    }

    public function __invoke(CompaniesQueryByUser $query): Response
    {
        $filters = [
            ['field' => 'users', 'operator' => 'CONTAINS', 'value' => $query->userId],
            ['field' => 'businessId', 'operator' => '=', 'value' => $query->businessId],
        ];
        return $this->finder->__invoke($filters);
    }
}