<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain\services;


use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\exceptions\FundingOrderNotExist;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FundingOrderCriteriaFinder
{
    public function __construct(private FundingOrderRepository $repository)
    {
    }

    public function __invoke(Filters $filters): FundingOrder
    {
        $findingOrder = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($findingOrder)) {
            throw new FundingOrderNotExist();
        }

        return $findingOrder[0];
    }
}