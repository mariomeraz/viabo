<?php declare(strict_types=1);


namespace Viabo\security\code\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCodeCommand implements Command
{
    public function __construct(public string $userId)
    {
    }

}