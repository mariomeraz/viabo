<?php declare(strict_types=1);


namespace Viabo\management\shared\domain\paymentProcessor;


use Viabo\management\card\domain\Card;
use Viabo\management\card\domain\CardCredentials;
use Viabo\management\cardMovement\domain\CardMovementFilter;
use Viabo\management\cardOperation\domain\CardOperations;
use Viabo\management\credential\domain\CardCredential;

interface PaymentProcessorAdapter
{
    public function register(CardCredential $credential): void;

    public function searchCardInformation(CardCredentials $credential): array;

    public function searchCardNip(Card $card): array;

    public function searchMovements(CardMovementFilter $cardMovement): array;

    public function searchCardBalance(Card $card): array;

    public function updateBlock(Card $card): void;

    public function transactionPay(CardOperations $operations): void;

    public function transactionReverse(CardOperations $operations): CardOperations;

}