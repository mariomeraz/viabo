<?php declare(strict_types=1);


namespace Viabo\security\user\application\reset_password_by_url;


use Viabo\shared\domain\bus\command\Command;

final readonly class ResetUserPasswordCommandByUrl implements Command
{
    public function __construct(public string $userId)
    {
    }
}