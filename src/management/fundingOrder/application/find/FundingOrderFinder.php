<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\fundingOrder\application\create\FundingOrderResponse;
use Viabo\management\fundingOrder\domain\exceptions\FundingOrderNotExist;
use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FundingOrderFinder
{
    public function __construct(private FundingOrderRepository $repository)
    {
    }

    public function __invoke(FundingOrderId $fundingOrderId): FundingOrderResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'id' , 'operator' => '=' , 'value' => $fundingOrderId->value()]
        ]);
        $fundingOrder = $this->repository->searchView(new Criteria($filters));

        if (empty($fundingOrder)) {
            throw new FundingOrderNotExist();
        }

        return new FundingOrderResponse($fundingOrder[0]->toArray());
    }
}