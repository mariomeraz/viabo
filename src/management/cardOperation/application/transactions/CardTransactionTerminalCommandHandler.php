<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\application\transactions;


use Viabo\management\cardOperation\domain\CardOperationPayEmail;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\credential\CardCredentialClientKey;
use Viabo\shared\domain\bus\command\CommandHandler;

final readonly class CardTransactionTerminalCommandHandler implements CommandHandler
{
    public function __construct(private CardTransactionsProcessor $processor)
    {
    }

    public function __invoke(CardTransactionTerminalCommand $command): void
    {
        $originCardId = new CardId($command->cardId);
        $clientKey = new CardCredentialClientKey($command->cardCredential['clientKey']);
        $payEmail = new CardOperationPayEmail($command->legalRepresentativeEmail);

        $isTerminal = true;
        $this->processor->__invoke(
            $originCardId ,
            $clientKey ,
            $payEmail ,
            $this->format($command->destinationCards , $command->terminalData) ,
            $command->terminalData['id'] ,
            $isTerminal
        );
    }

    private function format(array $destinationCards , array $terminalData): array
    {
        return array_map(function (array $card) use ($terminalData) {
            $card['cardId'] = $card['id'];
            $card['amount'] = strval($terminalData['amountToSettled']);
            $card['concept'] = "Liquidación de terminal virtual #{$terminalData['authorization_number']}";
            unset($card['id']);
            return $card;
        } , $destinationCards);
    }
}