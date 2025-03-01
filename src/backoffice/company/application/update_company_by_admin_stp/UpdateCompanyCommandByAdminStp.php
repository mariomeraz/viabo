<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_by_admin_stp;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCompanyCommandByAdminStp implements Command
{
    public function __construct(
        public string $userId,
        public string $companyId,
        public string $fiscalName,
        public string $commercialName,
        public string $stpAccountId,
        public array  $assignedUsers,
        public array  $costCenters,
        public array  $commissions
    )
    {
    }
}