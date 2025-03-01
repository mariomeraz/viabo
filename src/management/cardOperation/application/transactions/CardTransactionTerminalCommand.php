<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\transactions;


use Viabo\shared\domain\bus\command\Command;

final readonly class CardTransactionTerminalCommand implements Command
{
    public function __construct(
        public string $id ,
        public string $cardId ,
        public array  $destinationCards ,
        public array  $cardCredential ,
        public string $legalRepresentativeEmail ,
        public array  $terminalData
    )
    {
    }
}