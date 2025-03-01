<?php declare(strict_types=1);


namespace Viabo\shared\domain\service\find_business;


use Viabo\backofficeBusiness\business\application\find_business\BusinessQuery;
use Viabo\shared\domain\bus\query\QueryBus;

final class BusinessFinder
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(string $businessId): array
    {
        $business = $this->queryBus->ask(new BusinessQuery($businessId));
        return $business->data;
    }
}