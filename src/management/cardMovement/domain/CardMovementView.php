<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


final class CardMovementView
{

    public function __construct(
        private string  $id ,
        private string  $setTransactionId ,
        private string  $cardId ,
        private string  $cardMain ,
        private ?string $cardOwnerName ,
        private string  $cardNumber ,
        private string  $cardPaymentProcessorId ,
        private string  $commerceId ,
        private ?string $commerceName ,
        private string  $receiptId ,
        private ?string $receiptFiles ,
        private string  $type ,
        private string  $operationType ,
        private string  $amount ,
        private string  $concept ,
        private string  $description ,
        private string  $apiData ,
        private string  $date
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id ,
            'transactionId' => $this->setTransactionId ,
            'cardId' => $this->cardId ,
            'cardMain' => boolval($this->cardMain) ,
            'cardOwnerName' => $this->cardOwnerName ?? '' ,
            'cardNumber' => $this->cardNumber ,
            'cardPaymentProcessor' => $this->cardPaymentProcessorId ,
            'cardCommerceId' => $this->commerceId ,
            'cardCommerceName' => $this->commerceName ?? '' ,
            'receiptId' => $this->receiptId ??'',
            'receiptFiles' => $this->receiptFiles ?? '' ,
            'description' => $this->description ,
            'concept' => $this->concept ,
            'amount' => $this->amount ,
            'type' => $this->type ,
            'operationType' => $this->operationType ,
            'apiData' => $this->apiData ,
            'date' => $this->date ,
            'checked' => !empty($this->receiptId)
        ];
    }

}
