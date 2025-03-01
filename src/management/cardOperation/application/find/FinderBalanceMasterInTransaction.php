<?php declare(strict_types=1);

namespace Viabo\management\cardOperation\application\find;

use Viabo\management\cardOperation\domain\CardOperation;
use Viabo\management\cardOperation\domain\CardOperationRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinderBalanceMasterInTransaction
{
    public function __construct(private CardOperationRepository $repository)
    {
    }

    public function __invoke(array $cardsNumbers): BalanceMasterResponse
    {
        $total = 0;
        $cards = [];
        $balance = [];
        foreach ($cardsNumbers as $key => $card) {
            $cards = $cardsNumbers[$key];
            $filter = Filters::fromValues([
                ['field' => 'originCard.value' , 'operator' => 'IN' , 'value' => implode(',' , $cards)] ,
                ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
            ]);

            $operations = $this->repository->searchCriteria(new Criteria($filter));

            $total = array_sum(array_map(function (CardOperation $operation) {
                return $operation->amount()->value();
            } , $operations));
            $balance[$key] = strval($total);
        }

        return new BalanceMasterResponse($balance);
    }
}
