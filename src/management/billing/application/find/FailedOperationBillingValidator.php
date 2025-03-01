<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\management\billing\domain\BillingApiKey;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\management\billing\domain\exceptions\FailedOperationBilling;
use Viabo\management\billing\domain\services\BillingFinderByApiKey;

final readonly class FailedOperationBillingValidator
{
    private BillingFinderByApiKey $finder;

    public function __construct(private BillingRepository $repository)
    {
        $this->finder = new BillingFinderByApiKey($this->repository);
    }

    public function __invoke(BillingApiKey $apiKey): void
    {
        $billing = $this->finder->__invoke($apiKey);
        if(empty($billing)){
            throw new FailedOperationBilling();
        }
    }
}