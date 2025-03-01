<?php declare(strict_types=1);


namespace Viabo\tickets\message\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateMessageCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $messageId ,
        public string $ticketId ,
        public string $description ,
        public array  $uploadFiles
    )
    {
    }
}