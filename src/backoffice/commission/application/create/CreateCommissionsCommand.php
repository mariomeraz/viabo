<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCommissionsCommand implements Command
{
    public function __construct(
        public string $userId ,
        public string $commerceId ,
        public float $speiInCarnet ,
        public float $speiInMasterCard ,
        public float $speiOutCarnet ,
        public float $speiOutMasterCard ,
        public float $pay,
        public float $sharedTerminal
    )
    {
    }
}