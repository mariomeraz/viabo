<?php declare(strict_types=1);


namespace Viabo\security\code\application\delete;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DeleteCodeCommandHandler implements CommandHandler
{
    public function __construct(private CodeDeleter $deleter)
    {
    }

    public function __invoke(DeleteCodeCommand $command): void
    {
        $this->deleter->__invoke($command->userId, $command->code);
    }
}