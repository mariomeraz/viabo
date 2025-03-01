<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create_company_by_admin_stp;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCompanyCommandHandlerByAdminStp implements CommandHandler
{
    public function __construct(private CompanyCreatorByAdminStp $creator)
    {
    }

    public function __invoke(CreateCompanyCommandByAdminStp $command): void
    {
        $this->creator->__invoke(
            $command->userId,
            $command->businessId,
            $command->companyId,
            $command->fiscalName,
            $command->commercialName,
            $command->rfc,
            $command->stpAccount,
            $command->assignedUsers,
            $command->costCenters,
            $command->commissions
        );
    }
}