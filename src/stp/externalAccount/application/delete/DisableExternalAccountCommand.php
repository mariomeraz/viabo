<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\delete;


use Viabo\shared\domain\bus\command\Command;

final readonly class DisableExternalAccountCommand implements Command
{
    public function __construct(public string $userId , public string $externalAccountId)
    {
    }
}