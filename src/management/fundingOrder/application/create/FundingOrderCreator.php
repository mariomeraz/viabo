<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\create;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderTypeChargeNotDefine;
use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\shared\domain\paymentCash\PaymentCashAdapter;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class FundingOrderCreator
{
    public function __construct(
        private FundingOrderRepository $repository ,
        private PaymentCashAdapter     $adapter ,
        private EventBus               $bus
    )
    {
    }

    public function __invoke(
        string $fundingOrderId ,
        string $cardId ,
        string $cardNumber ,
        string $amount ,
        string $spei ,
        string $payCash ,
        array  $payCashData ,
        array  $payCashInstructionsData
    ): void
    {
        $fundingOrder = FundingOrder::create(
            $fundingOrderId ,
            $cardId ,
            $cardNumber ,
            $amount ,
            $spei ,
            $payCash ,
            $payCashData ,
            $payCashInstructionsData
        );

        if ($fundingOrder->isNotTypeCharge()) {
            throw new FundingOrderTypeChargeNotDefine();
        }

        if ($fundingOrder->isDefineTypeChargePayCash()) {
            $reference = $this->adapter->createReference($fundingOrder);
            $fundingOrder->updateReferencePayCash($reference);
            $referenceData = $this->adapter->searchReference($fundingOrder);
            $fundingOrder->setPayCashInstructionsUrl($referenceData);
        }

        $this->repository->save($fundingOrder);
        $fundingOrder->setEventCreated();

        $this->bus->publish(...$fundingOrder->pullDomainEvents());
    }

}