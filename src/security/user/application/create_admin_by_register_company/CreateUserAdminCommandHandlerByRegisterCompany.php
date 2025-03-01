<?php declare(strict_types=1);


namespace Viabo\security\user\application\create_admin_by_register_company;


use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CreateUserAdminCommandHandlerByRegisterCompany implements CommandHandler
{
    public function __construct(private UserAdminCreatorByRegisterCompany $creator)
    {
    }

    public function __invoke(CreateUserAdminCommandByRegisterCompany $command): void
    {
        $this->creator->__invoke(
            $command->name,
            $command->lastname,
            $command->phone,
            $command->email,
            $command->password,
            $command->confirmPassword
        );
    }
}