<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\update;


use Viabo\management\fundingOrder\domain\FundingOrderCanceledByUser;
use Viabo\management\fundingOrder\domain\FundingOrderId;
use Viabo\management\fundingOrder\domain\PayCashData;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CancelFundingOrderCommandHandler implements CommandHandler
{
    public function __construct(private FundingOrderCanceler $canceler)
    {
    }

    public function __invoke(CancelFundingOrderCommand $command): void
    {
        $fundingOrderId = FundingOrderId::create($command->fundingOrderId);
        $user = FundingOrderCanceledByUser::create($command->userId);
        $payCashData = PayCashData::create($command->payCashData);

        $this->canceler->__invoke($fundingOrderId, $user, $payCashData);
    }
}