<?php declare(strict_types=1);


namespace Viabo\backoffice\company\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class UpdateCommerceCommandByBackoffice implements Command
{
    public function __construct(
        public string $userId ,
        public string $commerceId ,
        public string $tradeName ,
        public string $fiscalName ,
        public string $rfc ,
        public string $fiscalPersonType ,
        public string $employees ,
        public string $branchOffices ,
        public string $postalAddress ,
        public string $phoneNumbers ,
        public string $slug ,
        public string $publicTerminal ,
        public array  $logo
    )
    {
    }

}