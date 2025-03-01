<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\delete;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class DeleteCompanyCommandHandler implements CommandHandler
{
    public function __construct(private CompanyDeleter $deleter)
    {
    }

    public function __invoke(DeleteCompanyCommand $command): void
    {
        $this->deleter->__invoke($command->companyId);
    }
}