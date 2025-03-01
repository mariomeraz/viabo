<?php declare(strict_types=1);


namespace Viabo\security\code\application\find;


use Viabo\shared\domain\bus\command\Command;

final readonly class CodeVerificationCommand implements Command
{
    public function __construct(public string $userId , public string $code)
    {
    }
}