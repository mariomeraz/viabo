<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_by_admin_stp;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCompanyCommandHandlerByAdminStp implements CommandHandler
{
    public function __construct(private CompanyUpdaterByAdminStp $updater)
    {
    }

    public function __invoke(UpdateCompanyCommandByAdminStp $command): void
    {
        $this->updater->__invoke(
            $command->userId,
            $command->companyId,
            $command->fiscalName,
            $command->commercialName,
            $command->stpAccountId,
            $command->assignedUsers,
            $command->costCenters,
            $command->commissions
        );
    }
}