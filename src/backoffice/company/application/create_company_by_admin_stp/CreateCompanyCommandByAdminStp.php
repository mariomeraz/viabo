<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\create_company_by_admin_stp;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCompanyCommandByAdminStp implements Command
{
    public function __construct(
        public string $userId,
        public string $businessId,
        public string $companyId,
        public string $fiscalName,
        public string $commercialName,
        public string $rfc,
        public string $stpAccount,
        public array  $assignedUsers,
        public array  $costCenters,
        public array  $commissions
    )
    {
    }
}