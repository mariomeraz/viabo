<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendFundingOrder;


use Viabo\shared\domain\bus\command\Command;

final readonly class SendFundingOrderCommand implements Command
{
    public function __construct(public array $fundingOrder , public array $emails)
    {
    }
}