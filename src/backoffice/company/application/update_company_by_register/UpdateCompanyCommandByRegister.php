<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_by_register;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCompanyCommandByRegister implements Command
{
    public function __construct(
        public string      $companyId,
        public string|null $fiscalPersonType,
        public string      $fiscalName,
        public string      $tradeName,
        public string      $rfc,
        public string      $registerStep,
        public array       $services
    )
    {
    }

}