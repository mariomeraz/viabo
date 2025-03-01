<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\application\create;

use Viabo\shared\domain\bus\command\Command;

final readonly class CreateTerminalTransactionLogCommand implements Command
{
    public function __construct(
        public array  $commercePayData ,
        public string $merchantId ,
        public string $apiKey ,
        public array  $cardData
    )
    {
    }
}
