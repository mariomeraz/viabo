<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateFundingOrderCommandHandler implements CommandHandler
{
    public function __construct(private FundingOrderCreator $creator)
    {
    }

    public function __invoke(CreateFundingOrderCommand $command): void
    {
        $this->creator->__invoke(
            $command->fundingOrderId ,
            $command->cardId ,
            $command->cardNumber ,
            $command->amount ,
            $command->spei ,
            $command->payCash ,
            $command->payCashData ,
            $command->payCashInstructionsData
        );
    }
}