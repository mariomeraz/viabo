<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\FundingOrderConciliationNumber;
use Viabo\management\fundingOrder\domain\FundingOrderConciliationUser;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class FundingOrderConciliationCommandHandler implements CommandHandler
{
    public function __construct(private FundingOrderConciliationUpdater $updater)
    {
    }

    public function __invoke(FundingOrderConciliationCommand $command): void
    {
        $fundingOrderId = FundingOrderId::create($command->fundingOrderId);
        $conciliationUserId = FundingOrderConciliationUser::create($command->userId);
        $numberConciliation = FundingOrderConciliationNumber::create($command->referenceNumber);

        $this->updater->__invoke($fundingOrderId , $conciliationUserId , $numberConciliation);
    }
}