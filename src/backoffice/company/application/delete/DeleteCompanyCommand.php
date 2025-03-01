<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\delete;


use Viabo\shared\domain\bus\command\Command;

final readonly class DeleteCompanyCommand implements Command
{
    public function __construct(public string $companyId)
    {
    }
}