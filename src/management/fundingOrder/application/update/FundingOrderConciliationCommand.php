<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class FundingOrderConciliationCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $fundingOrderId ,
        public string $referenceNumber
    )
    {
    }
}