<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\fundingOrder\application\create\FundingOrderResponse;
use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\shared\domain\card\CardId;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinishedFundingOrderFinder
{
    public function __construct(private FundingOrderRepository $repository)
    {
    }

    public function __invoke(CardId $cardId): FundingOrderResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'cardId' , 'operator' => '=' , 'value' => $cardId->value() ],
            ['field' => 'status.value' , 'operator' => 'IN' , 'value' => '11,9' ]
        ]);
        $fundingOrder = $this->repository->searchCriteria(new Criteria($filters));
        return new FundingOrderResponse(array_map(function (FundingOrder $fundingOrder){
            return $fundingOrder->toArray();
        },$fundingOrder));
    }
}