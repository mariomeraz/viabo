<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateTerminalTransactionBySlugCommandHandler implements CommandHandler
{
    public function __construct(private TerminalTransactionCreator $creator)
    {
    }

    public function __invoke(CreateTerminalTransactionBySlugCommand $command): void
    {
        $userId = '';
        $this->creator->__invoke(
            $userId ,
            $command->terminalTransactionId ,
            $command->commerceId ,
            $command->terminalId ,
            $command->clientName ,
            $command->email ,
            $command->phone ,
            $command->description ,
            $command->amount
        );
    }
}