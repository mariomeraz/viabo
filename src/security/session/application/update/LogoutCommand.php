<?php declare(strict_types=1);


namespace Viabo\security\session\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class LogoutCommand implements Command
{
    public function __construct(public string $userId)
    {
    }
}