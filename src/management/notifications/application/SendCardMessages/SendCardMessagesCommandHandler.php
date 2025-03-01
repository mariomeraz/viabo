<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardMessages;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class SendCardMessagesCommandHandler implements CommandHandler
{
    public function __construct(private SendCardMessages $send)
    {
    }

    public function __invoke(SendCardMessagesCommand $command): void
    {
        $this->send->__invoke($command->subject , $command->emails, $command->message);
    }
}