<?php declare(strict_types=1);


namespace Viabo\catalogs\threshold\application\find;


use Viabo\catalogs\threshold\domain\exceptions\FundingOrderThresholdNotExist;
use Viabo\catalogs\threshold\domain\ThresholdRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FundingOrderThresholdFinder
{
    public function __construct(private ThresholdRepository $repository)
    {
    }

    public function __invoke(): ThresholdResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'name.value' , 'operator' => '=' , 'value' => 'FundingOrder'] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);
        $threshold = $this->repository->searchCriteria(new Criteria($filters));

        if (empty($threshold)) {
            throw new FundingOrderThresholdNotExist();
        }

        return new ThresholdResponse($threshold[0]->toArray());
    }
}