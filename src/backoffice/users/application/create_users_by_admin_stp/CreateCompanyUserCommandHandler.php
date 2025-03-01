<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\create_users_by_admin_stp;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateCompanyUserCommandHandler implements CommandHandler
{
    public function __construct(private CompanyUsersCreatorByAdminSTP $creator)
    {
    }

    public function __invoke(CreateCompanyUserCommand $command): void
    {
        $this->creator->__invoke($command->company);
    }
}