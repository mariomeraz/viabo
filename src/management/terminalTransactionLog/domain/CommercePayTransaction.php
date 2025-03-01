<?php declare(strict_types=1);

namespace Viabo\management\terminalTransactionLog\domain;

use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransactionLog\domain\events\CommercePayTransactionCreatedDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class CommercePayTransaction extends AggregateRoot
{
    private CommercePayCardData $cardData;
    private CommercePayData $commercePayData;

    public function __construct(
        public CommercePayTransactionId         $id ,
        public CommercePayId                    $commercePayId ,
        public CommercePayTransactionStatusId   $statusId ,
        public CommercePayTransactionAPIMessage $apiMessage ,
        public CommercePayTransactionAPICode    $apiCode ,
        public CommercePayTransactionAPIData    $apiData ,
        public CommercePayTransactionTypeId     $typeId,
        public CommercePayTransactionDate       $date
    )
    {
        $this->cardData = CommercePayCardData::empty();
        $this->commercePayData = CommercePayData::empty();
    }

    public static function create(CommercePayId $commercePayId, CommercePayTransactionTypeId $typeId): self
    {
        return new self(
            CommercePayTransactionId::random() ,
            $commercePayId ,
            new CommercePayTransactionStatusId('') ,
            new CommercePayTransactionAPIMessage('') ,
            new CommercePayTransactionAPICode('') ,
            new CommercePayTransactionAPIData('') ,
            $typeId,
            CommercePayTransactionDate::todayDate()
        );
    }

    private function id(): CommercePayTransactionId
    {
        return $this->id;
    }

    public function setCardData(array $cardData): void
    {
        $this->cardData = new CommercePayCardData(
            $cardData['cardNumber'] ,
            $cardData['expMonth'] ,
            $cardData['expYear'] ,
            $cardData['security'] ,
            $cardData['cardHolder']
        );
    }

    public function setCommercePayData(array $data): void
    {
        $this->commercePayData = new CommercePayData(
            $data['reference'] ,
            $data['terminalId'] ,
            $data['email'] ,
            $data['phone'] ,
            $data['merchantId'] ,
            $data['apiKey'] ,
            $data['amount']
        );
    }

    public function commercePayData(): array
    {
        return $this->commercePayData->toArray();
    }

    public function date(): string
    {
        return $this->date->now();
    }

    public function cardData(): array
    {
        return $this->cardData->format();
    }

    public function addPaymentGateway(array $paymentGatewayData): void
    {
        $this->apiMessage = $this->apiMessage->update($paymentGatewayData['display_message']);
        $this->apiCode = $this->apiCode->update($paymentGatewayData['result_code']);
        $this->apiData = $this->apiData->update($paymentGatewayData);
    }

    public function updateStatus(): void
    {
        if ($this->apiCode->isApproved()) {
            $this->statusId = $this->statusId->charged();
        } else {
            $this->statusId = $this->statusId->refused();
        }
    }

    public function isNotApproved(): bool
    {
        return !$this->apiCode->isApproved();
    }

    public function apiMessage(): CommercePayTransactionAPIMessage
    {
        return $this->apiMessage;
    }

    public function setEventCreated(): void
    {
        $this->record(new CommercePayTransactionCreatedDomainEvent($this->id()->value() , $this->toArray()));
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'commercePayId' => $this->commercePayId->value() ,
            'statusId' => $this->statusId->value() ,
            'apiMessage' => $this->apiMessage->value() ,
            'apiCode' => $this->apiCode->value() ,
            'apiData' => json_decode($this->apiData->value(),true) ,
            'typeId' => $this->typeId->value(),
            'date' => $this->date->value()
        ];
    }

}
