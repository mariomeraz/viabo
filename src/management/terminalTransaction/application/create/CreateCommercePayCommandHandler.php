<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\application\create;

use Viabo\shared\domain\bus\query\QueryHandler;
use Viabo\shared\domain\bus\query\Response;

final readonly class CreateCommercePayCommandHandler implements QueryHandler
{
    public function __construct(private TerminalTransactionCreator $creator)
    {
    }

    public function __invoke(CreateCommercePayCommand $command): Response
    {
        return $this->creator->__invoke(
            $command->userId ,
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
