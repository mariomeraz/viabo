<?php declare(strict_types=1);


namespace Viabo\security\code\application\delete;


use Viabo\shared\domain\bus\command\Command;

final readonly class DeleteCodeCommand implements Command
{
    public function __construct(public string $userId , public string $code)
    {
    }
}