<?php declare(strict_types=1);


namespace Viabo\management\card\application\update;


use Viabo\shared\domain\bus\command\Command;

final readonly class AssignCardsCommandInCommerce implements Command
{
    public function __construct(
        public string $commerceId ,
        public string $paymentProcessor ,
        public string $amount
    )
    {
    }
}