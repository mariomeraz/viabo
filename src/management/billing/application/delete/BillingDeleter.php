<?php declare(strict_types=1);


namespace Viabo\management\billing\application\delete;


use Viabo\management\billing\domain\BillingId;
use Viabo\management\billing\domain\BillingRepository;

final readonly class BillingDeleter
{
    public function __construct(private BillingRepository $repository)
    {
    }

    public function __invoke(BillingId $billingId): void
    {
        $billing = $this->repository->search($billingId);

        if(empty($billing)){
            return;
        }

        $this->repository->delete($billing);
    }
}