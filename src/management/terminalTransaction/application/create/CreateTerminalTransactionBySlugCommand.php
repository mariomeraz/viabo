<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateTerminalTransactionBySlugCommand implements Command
{
    public function __construct(
        public string $terminalTransactionId ,
        public string $commerceId ,
        public string $terminalId ,
        public string $clientName ,
        public string $email ,
        public string $phone ,
        public string $description ,
        public string $amount
    )
    {
    }
}