<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateTerminalTransactionLiquidationStatusCommand implements Command
{
    public function __construct(public string $reference , public string $liquidationStatusId)
    {
    }
}