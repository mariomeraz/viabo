<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\create;

use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateTerminalTransactionCommandHandler implements CommandHandler
{
    public function __construct(private TerminalTransactionCreator $creator)
    {
    }

    public function __invoke(CreateTerminalTransactionCommand $command): void
    {
        $this->creator->__invoke(
            $command->terminalTransactionId ,
            $command->commerceId ,
            $command->terminalId ,
            $command->clientName ,
            $command->email ,
            $command->phone ,
            $command->description ,
            $command->amount ,
            $command->userId
        );
    }
}
