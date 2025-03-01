<?php declare(strict_types=1);


namespace Viabo\security\user\application\find;


use Viabo\shared\domain\bus\command\Command;

final readonly class ValidateUserNewCommand implements Command
{
    public function __construct(public string $userName, public string $userEmail)
    {
    }
}