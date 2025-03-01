<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\assign_user_in_company;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class AssignUserCommandHandlerInCompany implements CommandHandler
{
    public function __construct(private CompanyUserAssigner $assigner)
    {
    }

    public function __invoke(AssignUserCommandInCompany $command): void
    {
        $this->assigner->__invoke($command->businessId, $command->companyId, $command->userId);
    }
}