<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\create;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateMessageCommandHandler implements CommandHandler
{
    public function __construct(private MessageCreator $creator)
    {
    }

    public function __invoke(CreateMessageCommand $command): void
    {
        $this->creator->__invoke(
            $command->userId ,
            $command->messageId ,
            $command->ticketId ,
            $command->description ,
            $command->uploadFiles
        );
    }
}