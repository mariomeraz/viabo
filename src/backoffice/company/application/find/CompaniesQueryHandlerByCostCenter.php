<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CompaniesQueryHandlerByCostCenter implements QueryHandler
{
    public function __construct(private CompaniesFinderByCostCenter $finder)
    {
    }

    public function __invoke(CompaniesQueryByCostCenter $query): Response
    {
        return $this->finder->__invoke($query->costCenterId);
    }
}