<?php declare(strict_types=1);


namespace Viabo\management\card\application\create;


use Viabo\shared\domain\bus\command\Command;

final readonly class CreateCardCommand implements Command
{
    public function __construct(
        public string $cardRecorderId ,
        public string $cardNumber ,
        public string $expirationDate ,
        public string $cvv ,
        public string $cardPaymentProcessor ,
        public string $commerceId
    )
    {
    }
}