<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain\services;


use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\exceptions\FundingOrderNotExist;

final readonly class FundingOrderFinder
{
    public function __construct(private FundingOrderRepository $repository)
    {
    }

    public function __invoke(FundingOrderId $id): FundingOrder
    {
        $findingOrder = $this->repository->search($id);

        if (empty($findingOrder)) {
            throw new FundingOrderNotExist();
        }

        return $findingOrder;
    }
}