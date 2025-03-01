<?php declare(strict_types=1);


namespace Viabo\security\user\application\login;


use Viabo\shared\domain\bus\command\Command;

final readonly class LoginUserCommand implements Command
{
    public function __construct(public string $username, public string $password)
    {
    }
}