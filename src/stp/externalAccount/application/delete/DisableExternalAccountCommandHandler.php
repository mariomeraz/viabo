<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\delete;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DisableExternalAccountCommandHandler implements CommandHandler
{
    public function __construct(private ExternalAccountDisabler $disabler)
    {
    }

    public function __invoke(DisableExternalAccountCommand $command): void
    {
        $this->disabler->__invoke($command->userId , $command->externalAccountId);
    }
}