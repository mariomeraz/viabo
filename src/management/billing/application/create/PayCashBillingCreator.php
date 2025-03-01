<?php declare(strict_types=1);


namespace Viabo\management\billing\application\create;


use Viabo\management\billing\domain\BillingData;
use Viabo\management\billing\domain\BillingReferencePayCash;
use Viabo\management\billing\domain\BillingRepository;
use Viabo\management\billing\domain\PayCashBilling;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class PayCashBillingCreator
{
    public function __construct(private BillingRepository $repository, private EventBus $bus)
    {
    }

    public function __invoke(BillingReferencePayCash $referencePayCash , BillingData $data): void
    {
        $billing = PayCashBilling::create($referencePayCash, $data);

        $this->repository->savePayCashBilling($billing);

        $this->bus->publish(...$billing->pullDomainEvents());
    }
}