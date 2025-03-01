<?php declare(strict_types=1);

namespace Viabo\management\terminalTransaction\domain;

use Viabo\management\shared\domain\commercePay\CommercePayId;
use Viabo\management\terminalTransaction\domain\events\CommercePayCreatedDomainEvent;
use Viabo\management\terminalTransaction\domain\events\CommercePayUpdatedDomainEvent;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class CommercePay extends AggregateRoot
{

    public function __construct(
        private CommercePayId                  $id ,
        private CommercePayReference           $reference ,
        private CommercePayCommerceId          $commerceId ,
        private CommercePayTerminalId          $terminalId ,
        private CommercePayClientName          $clientName ,
        private CommercePayEmail               $email ,
        private CommercePayPhone               $phone ,
        private CommercePayDescription         $description ,
        private CommercePayAmount              $amount ,
        private CommercePayStatusId            $statusId ,
        private CommercePayLiquidationStatusId $liquidationStatusId ,
        private CommercePayUrlCode             $urlCode ,
        private CommercePayApiAuthCode         $apiAuthCode ,
        private CommercePayApiReferenceNumber  $apiReferenceNumber ,
        private CommercePayCreatedByUser       $createdByUser ,
        private CommercePayRegisterDate        $registerDate ,
        private CommercePayPaymentDate         $paymentDate
    )
    {
    }

    public static function create(
        string $terminalTransactionId ,
        string $commerceId ,
        string $terminalId ,
        string $clientName ,
        string $email ,
        string $phone ,
        string $description ,
        string $amount ,
        string $createdByUser ,
    ): self
    {
        $transaction = new self(
            new CommercePayId($terminalTransactionId) ,
            CommercePayReference::random() ,
            CommercePayCommerceId::create($commerceId) ,
            CommercePayTerminalId::create($terminalId) ,
            CommercePayClientName::create($clientName) ,
            CommercePayEmail::create($email) ,
            new CommercePayPhone($phone) ,
            new CommercePayDescription($description) ,
            CommercePayAmount::create($amount) ,
            CommercePayStatusId::pending() ,
            CommercePayLiquidationStatusId::unLiquidated() ,
            CommercePayUrlCode::random() ,
            CommercePayApiAuthCode::empty() ,
            CommercePayApiReferenceNumber::empty() ,
            new CommercePayCreatedByUser($createdByUser) ,
            CommercePayRegisterDate::todayDate() ,
            CommercePayPaymentDate::empty()
        );
        $transaction->record(new CommercePayCreatedDomainEvent(
            $transaction->id->value() ,
            $transaction->toArray() ,
            $transaction->email->value()
        ));
        return $transaction;
    }

    private function id(): CommercePayId
    {
        return $this->id;
    }

    public function active(): CommercePayStatusId
    {
        return $this->statusId;
    }

    public function urlCode(): CommercePayUrlCode
    {
        return $this->urlCode;
    }

    public function update(
        CommercePayStatusId           $statusId ,
        CommercePayApiAuthCode        $authCode ,
        CommercePayApiReferenceNumber $referenceNumber
    ): void
    {
        $this->statusId = $statusId;
        $this->apiAuthCode = $authCode;
        $this->apiReferenceNumber = $referenceNumber;

        if ($this->statusId->isApproved()) {
            $this->paymentDate = $this->paymentDate->update();
        }

        $this->record(new CommercePayUpdatedDomainEvent($this->id()->value() , $this->toArray()));
    }

    public function updateLiquidationStatusId(string $liquidationStatusId): void
    {
        $this->liquidationStatusId = $this->liquidationStatusId->update($liquidationStatusId);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'reference' => $this->reference->value() ,
            'commerceId' => $this->commerceId->value() ,
            'terminalId' => $this->terminalId->value() ,
            'fullName' => $this->clientName->value() ,
            'email' => $this->email->value() ,
            'phone' => $this->phone->value() ,
            'description' => $this->description->value() ,
            'amount' => $this->amount->value() ,
            'urlCode' => $this->urlCode->value() ,
            'apiAuthCode' => $this->apiAuthCode->value() ,
            'apiReferenceCode' => $this->apiReferenceNumber->value() ,
            'statusId' => $this->statusId->value() ,
            'liquidationStatusId' => $this->liquidationStatusId->value() ,
            'createdByUser' => $this->createdByUser->value() ,
            'registerDate' => $this->registerDate->value()
        ];
    }
}
