<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\shared\domain\criteria\Criteria;

interface FundingOrderRepository
{
    public function save(FundingOrder $conciliation): void;

    public function search(FundingOrderId $conciliationId): ?FundingOrder;

    public function searchReferenceNumber(FundingOrderReferenceNumber $referenceNumber): ?FundingOrder;

    public function searchCriteria(Criteria $criteria): array;

    public function searchView(Criteria $criteria): array;

    public function update(FundingOrder $fundingOrder): void;
}