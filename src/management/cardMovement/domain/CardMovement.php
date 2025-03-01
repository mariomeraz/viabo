<?php declare(strict_types=1);


namespace Viabo\management\cardMovement\domain;


use Viabo\management\card\domain\CardPaymentProcessorId;
use Viabo\management\shared\domain\card\CardCommerceId;
use Viabo\management\shared\domain\card\CardId;
use Viabo\management\shared\domain\card\CardNumber;
use Viabo\shared\domain\aggregate\AggregateRoot;

final class CardMovement extends AggregateRoot
{

    public function __construct(
        private CardMovementId               $id ,
        private CardMovementSetTransactionId $setTransactionId ,
        private CardId                       $cardId ,
        private CardNumber                   $cardNumber ,
        private CardPaymentProcessorId       $cardPaymentProcessorId ,
        private CardCommerceId               $commerceId ,
        private CardMovementReceiptId        $receiptId ,
        private CardMovementType             $type ,
        private CardMovementOperationType    $operationType ,
        private CardMovementAmount           $amount ,
        private CardMovementConcept          $concept ,
        private CardMovementDescription      $description ,
        private CardMovementApiData          $apiData ,
        private CardMovementDate             $date
    )
    {
    }

    public static function fromSetApiValue(
        string $cardId ,
        string $cardNumber ,
        string $paymentProcessor ,
        string $commerceId ,
        string $receiptId ,
        ?string $receiptFiles,
        array  $setApiData ,
        array  $operations
    ): static
    {
        $type = CardMovementType::create($setApiData['Type_Id']);
        $transactionId = CardMovementSetTransactionId::create($setApiData['Auth_Code']);

        return new static(
            CardMovementId::random() ,
            $transactionId ,
            CardId::create($cardId) ,
            CardNumber::create($cardNumber) ,
            new CardPaymentProcessorId($paymentProcessor) ,
            new CardCommerceId($commerceId) ,
            CardMovementReceiptId::fromValues($receiptId, $receiptFiles) ,
            $type ,
            CardMovementOperationType::fromOperations($operations , $transactionId , $type->isExpense()) ,
            CardMovementAmount::fromType($setApiData , $type->isExpense()) ,
            CardMovementConcept::fromOperations($transactionId , $operations) ,
            CardMovementDescription::fromOperations($setApiData['Merchant'] , $transactionId , $operations) ,
            CardMovementApiData::fromAPI($setApiData) ,
            CardMovementDate::create($setApiData['Date'])
        );
    }

    public static function fromValue(array $value): static
    {
        return new static(
            CardMovementId::random() ,
            CardMovementSetTransactionId::create($value['transactionId']) ,
            CardId::create($value['cardId']) ,
            CardNumber::create($value['cardNumber']) ,
            new CardPaymentProcessorId($value['cardPaymentProcessor']) ,
            new CardCommerceId($value['cardCommerceId']) ,
            new CardMovementReceiptId($value['receiptId']) ,
            CardMovementType::fromName($value['type']) ,
            CardMovementOperationType::create($value['operationType']) ,
            CardMovementAmount::create($value['amount']) ,
            new CardMovementConcept($value['concept']) ,
            new CardMovementDescription($value['description']) ,
            new CardMovementApiData($value['apiData']) ,
            CardMovementDate::create($value['date'])
        );
    }

    public function transactionId(): string
    {
        return $this->setTransactionId->value();
    }

    public function cardNumber(): string
    {
        return $this->cardNumber->value();
    }

    public function receiptId(): string
    {
        return $this->receiptId->value();
    }

    public function isNotConsolidated(mixed $mainCardTransactionsId): bool
    {
        return !in_array($this->setTransactionId->value() , $mainCardTransactionsId);
    }

    public function isIncome(): bool
    {
        return $this->type->isIncome();
    }

    public function isNotOperationTypeExternalCharge(): bool
    {
        return !$this->operationType->isExternalCharges();
    }

    public function hasReceipt(): bool
    {
        return $this->receiptId->isChecked();
    }

    public function updateReceipt(string $receiptId): void
    {
        $this->receiptId = $this->receiptId->update($receiptId);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value() ,
            'transactionId' => $this->setTransactionId->value() ,
            'cardId' => $this->cardId->value() ,
            'cardNumber' => $this->cardNumber->value() ,
            'cardPaymentProcessor' => $this->cardPaymentProcessorId->value() ,
            'cardCommerceId' => $this->commerceId->value() ,
            'receiptId' => $this->receiptId->value() ,
            'receiptFiles' => $this->receiptId->files() ,
            'description' => $this->description->value() ,
            'concept' => $this->concept->value() ,
            'amount' => $this->amount->value() ,
            'type' => $this->type->value() ,
            'operationType' => $this->operationType->value() ,
            'apiData' => $this->apiData->value() ,
            'date' => $this->date->value() ,
            'checked' => $this->receiptId->isChecked()
        ];
    }

}
