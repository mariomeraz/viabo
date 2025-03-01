<?php declare(strict_types=1);


namespace Viabo\stp\stpAccount\application\find_stp_account_by_business;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StpAccountQueryHandlerByBusiness implements QueryHandler
{
    public function __construct(private StpAccountFinderByBusiness $finder)
    {
    }

    public function __invoke(StpAccountQueryByBusiness $query): Response
    {
        return $this->finder->__invoke($query->businessId);
    }
}