<?php declare(strict_types=1);


namespace Viabo\management\notifications\application\SendCardMessages;


use Viabo\shared\domain\bus\command\Command;

final readonly class SendCardMessagesCommand implements Command
{
    public function __construct(public string $subject , public array $emails , public string $message)
    {
    }
}