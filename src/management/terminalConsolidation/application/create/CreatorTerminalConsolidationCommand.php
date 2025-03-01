<?php declare(strict_types=1);

namespace Viabo\management\terminalConsolidation\application\create;

use Viabo\shared\domain\bus\command\Command;

final readonly class CreatorTerminalConsolidationCommand implements Command
{
    public function __construct(
        public string $commerceId,
        public string $userId,
        public string $speiCardTransactionId,
        public string $speiCardTransactionAmount,
        public string $terminalId ,
        public array $transactions,
        public mixed $threshold
    )
    {
    }
}
