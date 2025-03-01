<?php declare(strict_types=1);


namespace Viabo\security\user\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class DemoUserValidateCommand implements Command
{
    public function __construct(public string $userEmail)
    {
    }
}