<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update_company_by_register;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class UpdateCompanyCommandHandlerByRegister implements CommandHandler
{
    public function __construct(private CompanyUpdaterByRegister $updater)
    {
    }

    public function __invoke(UpdateCompanyCommandByRegister $command): void
    {
        $this->updater->__invoke(
            $command->companyId ,
            $command->fiscalPersonType ,
            $command->fiscalName ,
            $command->tradeName ,
            $command->rfc ,
            $command->registerStep,
            $command->services
        );
    }
}