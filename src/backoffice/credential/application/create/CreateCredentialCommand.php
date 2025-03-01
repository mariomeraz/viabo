<?php declare(strict_types=1);


namespace Viabo\backoffice\credential\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCredentialCommand implements Command
{

    public function __construct(
        public string $commerceId ,
        public string $commerceKey ,
        public string $masterCardKey ,
        public string $carnetKey
    )
    {
    }
}