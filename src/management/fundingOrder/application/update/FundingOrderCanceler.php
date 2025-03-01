<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\management\fundingOrder\domain\exceptions\FundingOrderCannotBeCanceled;
use Viabo\management\fundingOrder\domain\FundingOrderCanceledByUser;
use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\PayCashData;
use Viabo\management\fundingOrder\domain\services\FundingOrderFinder;
use Viabo\management\shared\domain\paymentCash\PaymentCashAdapter;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class FundingOrderCanceler
{
    public function __construct(
        private FundingOrderRepository $repository ,
        private FundingOrderFinder     $finder ,
        private PaymentCashAdapter     $adapter ,
        private EventBus               $bus
    )
    {
    }

    public function __invoke(
        FundingOrderId             $fundingOrderId ,
        FundingOrderCanceledByUser $user ,
        PayCashData                $payCashData ,
    ): void
    {
        $fundingOrder = $this->finder->__invoke($fundingOrderId);

        if ($fundingOrder->hasNotValidStatusToCancel()) {
            throw new FundingOrderCannotBeCanceled();
        }

        $fundingOrder->cancel($user , $payCashData);
        
        if ($fundingOrder->isDefineTypeChargePayCash()) {
            $this->adapter->cancel($fundingOrder);
        }

        $this->repository->update($fundingOrder);
        
        $this->bus->publish(...$fundingOrder->pullDomainEvents());
    }
}