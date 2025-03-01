<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\find;


use Viabo\management\fundingOrder\application\create\FundingOrderResponse;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\FundingOrderView;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FundingOrdersFinder
{

    public function __construct(private FundingOrderRepository $repository)
    {
    }

    public function __invoke(array $cardsData): FundingOrderResponse
    {
        $cardsId = $this->cardsId($cardsData);
        $filters = Filters::fromValues([
            ['field' => 'cardId' , 'operator' => 'IN' , 'value' => $cardsId ]
        ]);
        $fundingOrders = $this->repository->searchView(new Criteria($filters));
        return new FundingOrderResponse(array_map(function (FundingOrderView $fundingOrder){
            return $fundingOrder->toArray();
        }, $fundingOrders));
    }

    private function cardsId(array $cardsData): string
    {
        $cardsIds = array_map(function (array $cardData) {
            return $cardData['id'];
        } , $cardsData);

        return implode(',' , $cardsIds);
    }
}