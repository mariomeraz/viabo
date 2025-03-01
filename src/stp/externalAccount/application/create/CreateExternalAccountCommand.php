<?php declare(strict_types=1);


namespace Viabo\stp\externalAccount\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateExternalAccountCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $interbankCLABE ,
        public string $beneficiary ,
        public string $rfc ,
        public string $alias ,
        public string $bankId ,
        public string $email ,
        public string $phone
    )
    {
    }
}