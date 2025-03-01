<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\assign_user_in_company;


use Viabo\shared\domain\bus\command\Command;

final readonly class AssignUserCommandInCompany implements Command
{
    public function __construct(
        public string $businessId,
        public string $companyId,
        public string $userId
    )
    {
    }
}