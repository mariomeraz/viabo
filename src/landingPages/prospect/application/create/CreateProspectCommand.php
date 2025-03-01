<?php declare(strict_types=1);


namespace Viabo\landingPages\prospect\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateProspectCommand implements Command
{
    public function __construct(
        public string $businessType ,
        public string $name ,
        public string $lastname ,
        public string $company ,
        public string $email ,
        public string $phone ,
        public string $contactMethod
    )
    {
    }
}