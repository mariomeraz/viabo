<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateFundingOrderCommand implements Command
{
    public function __construct(
        public string $fundingOrderId ,
        public string $cardId ,
        public string $cardNumber ,
        public string $amount ,
        public string $spei ,
        public string $payCash ,
        public array  $payCashData ,
        public array  $payCashInstructionsData
    )
    {
    }
}