<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCommercePay;


use Viabo\shared\domain\bus\command\Command;

final readonly class SendNotificationTerminalTransactionCommand implements Command
{
    public function __construct(public array $terminalTransaction)
    {
    }
}