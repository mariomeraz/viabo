<?php declare(strict_types=1);


namespace Viabo\backoffice\users\application\create_users_by_admin_stp;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCompanyUserCommand implements Command
{
    public function __construct(public array $company)
    {
    }
}