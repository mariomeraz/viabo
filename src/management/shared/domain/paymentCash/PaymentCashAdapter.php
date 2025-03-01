<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\paymentCash;


use Viabo\management\fundingOrder\domain\FundingOrder;

interface PaymentCashAdapter
{
    public function createReference(FundingOrder $fundingOrder): string;

    public function searchReference(FundingOrder $fundingOrder): array;

    public function cancel(FundingOrder $fundingOrder): void;
}