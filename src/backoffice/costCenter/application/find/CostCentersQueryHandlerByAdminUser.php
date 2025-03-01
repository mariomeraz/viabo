<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\application\find;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CostCentersQueryHandlerByAdminUser implements QueryHandler
{
    public function __construct(private CostCentersFinderByAdminUser $finder)
    {
    }

    public function __invoke(CostCentersQueryByAdminUser $query): Response
    {
        return $this->finder->__invoke($query->userId);
    }
}