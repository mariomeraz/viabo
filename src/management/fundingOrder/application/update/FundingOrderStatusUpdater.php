<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\management\fundingOrder\domain\FundingOrder;
use Viabo\management\fundingOrder\domain\FundingOrderReferencePayCash;
use Viabo\management\fundingOrder\domain\FundingOrderRepository;
use Viabo\management\fundingOrder\domain\FundingOrderStatusId;
use Viabo\management\fundingOrder\domain\services\FundingOrderCriteriaFinder;
use Viabo\shared\domain\bus\event\EventBus;
use Viabo\shared\domain\criteria\Filters;

final readonly class FundingOrderStatusUpdater
{
    public function __construct(
        private FundingOrderRepository     $repository ,
        private FundingOrderCriteriaFinder $finder ,
        private EventBus                   $bus)
    {
    }

    public function __invoke(FundingOrderReferencePayCash $referencePayCash , FundingOrderStatusId $status): void
    {

        $fundingOrder = $this->searchFundingOrder($referencePayCash);

        if (empty($fundingOrder) || $fundingOrder->hasAnInvalidStatus()) {
            return;
        }

        $fundingOrder->updateStatus($status);
        $this->repository->update($fundingOrder);

        $this->bus->publish(...$fundingOrder->pullDomainEvents());
    }

    private function searchFundingOrder(FundingOrderReferencePayCash $referencePayCash): FundingOrder|null
    {
        try {
            $filters = Filters::fromValues([
                ['field' => 'referencePayCash.value' , 'operator' => '=' , 'value' => $referencePayCash->value()]
            ]);
            return $this->finder->__invoke($filters);
        } catch (\DomainException) {
            return null;
        }
    }
}