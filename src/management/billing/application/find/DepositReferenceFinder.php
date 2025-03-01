<?php declare(strict_types=1);


namespace Viabo\management\billing\application\find;


use Viabo\management\billing\domain\Billing;
use Viabo\management\billing\domain\BillingApiKey;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\shared\domain\criteria\Criteria;
use Viabo\shared\domain\criteria\Filters;

final readonly class DepositReferenceFinder
{
    public function __construct(private BillingRepository $repository)
    {
    }

    public function __invoke(BillingApiKey $apiKey): DepositReferenceResponse
    {
        $filter = Filters::fromValues([
            ['field' => 'apiKey.value' , 'operator' => '=' , 'value' => $apiKey->value()]
        ]);
        $deposits = $this->repository->searchCriteria(new Criteria($filter));

        return new DepositReferenceResponse($this->getReferenceData($deposits));
    }

    private function getReferenceData(?array $deposits): array
    {
        if (empty($deposits)) {
            return [];
        }

        return array_map(function (Billing $deposit) {
            return $deposit->toArrayReference();
        } , $deposits)[0];
    }
}