<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class ToggleCompanyCommand implements Command
{
    public function __construct(
        public string $userId,
        public string $companyId,
        public bool   $active
    )
    {
    }
}