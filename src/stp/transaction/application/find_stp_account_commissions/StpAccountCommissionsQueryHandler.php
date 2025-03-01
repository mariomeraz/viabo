<?php declare(strict_types=1);


namespace Viabo\stp\transaction\application\find_stp_account_commissions;


use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class StpAccountCommissionsQueryHandler implements QueryHandler
{
    public function __construct(private StpAccountCommissionsFinder $finder)
    {
    }

    public function __invoke(StpAccountCommissionsQuery $query): Response
    {
        return $this->finder->__invoke($query->businessId, $query->startDay, $query->endDay);
    }
}