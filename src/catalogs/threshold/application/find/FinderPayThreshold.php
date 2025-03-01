<?php declare(strict_types=1);

namespace Viabo\catalogs\threshold\application\find;

use Viabo\catalogs\threshold\domain\ThresholdName;
use Viabo\catalogs\threshold\domain\ThresholdRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class FinderPayThreshold
{
    public function __construct(private ThresholdRepository $repository)
    {
    }

    public function __invoke(ThresholdName $name):PayThresholdResponse
    {
        $filters = Filters::fromValues([
            ['field' => 'name.value' , 'operator' => '=' , 'value' => $name->value()] ,
            ['field' => 'active.value' , 'operator' => '=' , 'value' => '1']
        ]);
        $threshold = $this->repository->searchCriteria(new Criteria($filters));

        $value = empty($threshold) ? "9" : $threshold[0]->value()->value();

        return new PayThresholdResponse(['threshold'=>$value]);

    }
}
