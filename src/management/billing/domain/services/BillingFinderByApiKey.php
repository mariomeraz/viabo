<?php declare(strict_types=1);


namespace Viabo\management\billing\domain\services;


use Viabo\management\billing\domain\Billing;
use Viabo\management\billing\domain\BillingApiKey;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class BillingFinderByApiKey
{

    public function __construct(private BillingRepository $repository)
    {
    }

    public function __invoke(BillingApiKey $apiKey): Billing|null
    {
        $filter = Filters::fromValues([
            ['field' => 'apiKey.value' , 'operator' => '=' , 'value' => $apiKey->value()]
        ]);

        $billing = $this->repository->searchCriteria(new Criteria($filter));

        return empty($billing) ? null : $billing[0];
    }
}