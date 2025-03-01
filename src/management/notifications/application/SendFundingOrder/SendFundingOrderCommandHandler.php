<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendFundingOrder;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendFundingOrderCommandHandler implements CommandHandler
{
    public function __construct(private FundingOrderSender $sender)
    {
    }

    public function __invoke(SendFundingOrderCommand $command): void
    {
        $this->sender->__invoke($command->fundingOrder, $command->emails);
    }
}