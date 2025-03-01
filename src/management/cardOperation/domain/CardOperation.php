<?php declare(strict_types=1);


namespace Viabo\management\cardOperation\domain;


use Viabo\management\cardOperation\domain\events\CardOperationCreatedDomainEvent;
use Viabo\management\cardOperation\domain\events\CardOperationUpdateDomainEvent;
use Viabo\management\cardOperation\domain\events\OperationFailedDomainEvent;
use Viabo\management\shared\domain\credential\CardCredentialClientKey;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class CardOperation extends AggregateRoot
{

    public function __construct(
        private CardOperationId                   $id ,
        private CardOperationTypeId               $typeId ,
        private CardOperationReferenceTerminal    $referenceTerminal ,
        private CardOperationOrigin               $originCard ,
        private CardOperationOriginMain           $originCardMain ,
        private CardOperationDestination          $destinationCard ,
        private CardOperationPayTransactionId     $payTransactionId ,
        private CardOperationReverseTransactionId $reverseTransactionId ,
        private CardOperationDescriptionPay       $descriptionPay ,
        private CardOperationDescriptionReverse   $descriptionReverse ,
        private CardOperationBalance              $balance ,
        private CardOperationConcept              $concept ,
        private CardOperationPayData              $payData ,
        private CardOperationReverseData          $reverseData ,
        private CardOperationPayEmail             $payEmail ,
        private CardOperationReverseEmail         $reverseEmail ,
        private CardCredentialClientKey           $clientKey ,
        private CardOperationRegisterDate         $registerDate ,
        private CardOperationActive               $active
    )
    {
    }

    public static function create(
        CardOperationTypeId            $operationTypeId ,
        CardOperationReferenceTerminal $referenceTerminal ,
        CardOperationOrigin            $originCard ,
        CardOperationOriginMain        $originCardMain ,
        CardOperationDestination       $destinationCard ,
        CardOperationBalance           $balance ,
        CardOperationConcept           $concept ,
        CardOperationPayEmail          $payEmail ,
        CardOperationReverseEmail      $reverseEmail ,
        CardCredentialClientKey        $clientKey ,
        CardOperationDescriptionPay    $descriptionPay ,
        CardOperationActive            $active
    ): static
    {
        return new static(
            CardOperationId::random() ,
            $operationTypeId ,
            $referenceTerminal ,
            $originCard ,
            $originCardMain ,
            $destinationCard ,
            new CardOperationPayTransactionId('') ,
            new CardOperationReverseTransactionId('') ,
            $descriptionPay ,
            new CardOperationDescriptionReverse('') ,
            $balance ,
            $concept ,
            new CardOperationPayData('') ,
            new CardOperationReverseData('') ,
            $payEmail ,
            $reverseEmail ,
            $clientKey ,
            CardOperationRegisterDate::todayDate() ,
            $active
        );
    }

    public function clientKey(): CardCredentialClientKey
    {
        return $this->clientKey;
    }

    public function originCard(): CardOperationOrigin
    {
        return $this->originCard;
    }

    public function destinationCard(): CardOperationDestination
    {
        return $this->destinationCard;
    }

    public function amount(): CardOperationBalance
    {
        return $this->balance;
    }

    public function descriptionPay(): CardOperationDescriptionPay
    {
        return $this->descriptionPay;
    }

    public function descriptionReverse(): CardOperationDescriptionReverse
    {
        return $this->descriptionReverse;
    }

    public function setDescriptionReverse(string $mainCard): void
    {
        $this->descriptionReverse = $this->descriptionReverse->update($this->originCard->last8Digits() , $mainCard);
    }

    public function updatePayData(array $payData): void
    {
        $this->payTransactionId = $this->payTransactionId->update(strval($payData['Auth_Code']));
        $this->payData = $this->payData->update($payData);
    }

    public function updateReverseData(array $reverseData): void
    {
        $this->reverseTransactionId = $this->reverseTransactionId->update(strval($reverseData['Auth_Code']));
        $this->reverseData = $this->reverseData->update($reverseData);
        $this->active = $this->active->update('0');
    }

    public function hasBalance(): bool
    {
        return $this->balance->hasBalance();
    }

    public function setEventCreated(): void
    {
        $this->record(new CardOperationCreatedDomainEvent(
            $this->id->value() , $this->toArray() , $this->payEmail->value()
        ));
    }

    public function setEventUpdate(): void
    {
        $this->record(new CardOperationUpdateDomainEvent(
            $this->id->value() , $this->toArray() , $this->reverseEmail->value()
        ));
    }

    public function setEventOperationFailed(string $billingId): void
    {
        $this->clearDomainEvents();
        $data = $this->toArray();
        $data['billingId'] = $billingId;
        $this->record(new OperationFailedDomainEvent($this->id->value() , $data));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'typeId' => $this->typeId->value() ,
            'referenceTerminal' => $this->referenceTerminal->value() ,
            'originCard' => $this->originCard->value() ,
            'originCardMain' => $this->originCardMain->value() ,
            'destinationCard' => $this->destinationCard->value() ,
            'payTransactionId' => $this->payTransactionId->value() ,
            'reverseTransactionId' => $this->reverseTransactionId->value() ,
            'descriptionPay' => $this->descriptionPay->value() ,
            'descriptionReverse' => $this->descriptionReverse->value() ,
            'balance' => $this->balance->value() ,
            'concept' => $this->concept->value() ,
            'payData' => $this->payData->value() ,
            'reverseData' => $this->reverseData->value() ,
            'clientKey' => $this->clientKey->value() ,
            'registerDate' => $this->registerDate->value() ,
            'active' => $this->active->value()
        ];
    }
}