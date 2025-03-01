<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain;


final class CommercePayView
{
    public function __construct(
        private string      $id ,
        private string      $reference ,
        private string      $commerceId ,
        private string      $commerceName ,
        private string|null $sharedTerminalCommission ,
        private string      $terminalId ,
        private string      $clientName ,
        private string      $email ,
        private string      $phone ,
        private string      $description ,
        private string      $amount ,
        private string      $statusId ,
        private string      $statusName ,
        private string      $liquidationStatusId ,
        private string      $liquidationStatusName ,
        private string      $apiAuthCode ,
        private string      $apiReferenceNumber ,
        private string      $urlCode ,
        private string      $createdByUser ,
        private string      $registerDate
    )
    {
    }

    public function reference(): string
    {
        return $this->reference;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ,
            'reference' => $this->reference ,
            'commerceId' => $this->commerceId ,
            'commerceName' => $this->commerceName ,
            'sharedTerminalCommission' => $this->sharedTerminalCommission ,
            'terminalId' => $this->terminalId ,
            'clientName' => $this->clientName ,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'description' => $this->description ,
            'amount' => $this->amount ,
            'statusId' => $this->statusId ,
            'statusName' => $this->statusName ,
            'liquidationStatusId' => $this->liquidationStatusId ,
            'liquidationStatusName' => $this->liquidationStatusName ,
            'urlCode' => $this->urlCode ,
            'createdByUser' => $this->createdByUser ,
            'registerDate' => $this->registerDate
        ];
    }

    public function toLinkDataArray(): array
    {
        return [
            'id' => $this->id ,
            'commerceId' => $this->commerceId ,
            'terminalId' => $this->terminalId ,
            'reference' => $this->reference ,
            'clientName' => $this->clientName ,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'description' => $this->description ,
            'amount' => $this->amount ,
            'statusId' => $this->statusId ,
            'apiAuthCode' => $this->apiAuthCode ,
            'apiReferenceNumber' => $this->apiReferenceNumber ,
            'statusName' => $this->statusName
        ];
    }
}