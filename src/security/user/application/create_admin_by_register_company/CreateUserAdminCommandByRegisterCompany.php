<?php declare(strict_types=1);


namespace Viabo\security\user\application\create_admin_by_register_company;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateUserAdminCommandByRegisterCompany implements Command
{
    public function __construct(
        public string $name,
        public string $lastname,
        public string $phone,
        public string $email,
        public string $password,
        public string $confirmPassword
    )
    {
    }

}