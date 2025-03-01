<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class ToggleCompanyCommandHandler implements CommandHandler
{
    public function __construct(private CompanyActivator $activator)
    {
    }

    public function __invoke(ToggleCompanyCommand $command): void
    {
        $this->activator->__invoke($command->userId, $command->companyId, $command->active);
    }
}