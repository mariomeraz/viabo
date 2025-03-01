<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\FundingOrderConciliationNumber;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\FundingOrderConciliationUser;
use Viabo\management\fundingOrder\domain\services\FundingOrderFinder;
use Viabo\shared\domain\bus\event\EventBus;

final readonly class FundingOrderConciliationUpdater
{
    public function __construct(
        private FundingOrderRepository $repository ,
        private FundingOrderFinder     $finder ,
        private EventBus               $bus
    )
    {
    }

    public function __invoke(
        FundingOrderId                 $fundingOrderId ,
        FundingOrderConciliationUser   $conciliationUserId ,
        FundingOrderConciliationNumber $numberConciliation
    ): void
    {
        $fundingOrder = $this->finder->__invoke($fundingOrderId);
        $fundingOrder->setConciliation($conciliationUserId , $numberConciliation);
        $this->repository->update($fundingOrder);

        $this->bus->publish(...$fundingOrder->pullDomainEvents());
    }
}