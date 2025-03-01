<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain;


final class PharosTransaction
{

    private string $commerceId;
    private string $commerceName;
    private float $commission;
    private float $amountCharged;
    private float $amountToSettled;
    private string $liquidationStatusId;
    private string $liquidationStatusName;

    public function __construct(
        private mixed $id ,
        private mixed $authorization_number ,
        private mixed $transaction_date ,
        private mixed $amount ,
        private mixed $approved ,
        private mixed $terminal_id ,
        private mixed $terminal_type ,
        private mixed $terminal_name ,
        private mixed $terminal_speiCard ,
        private mixed $terminal_shared ,
        private mixed $message ,
        private mixed $reversed ,
        private mixed $card_number ,
        private mixed $issuer ,
        private mixed $card_brand ,
        private mixed $conciliated ,
    )
    {
        $this->commerceId = '';
        $this->commerceName = '';
        $this->commission = 0;
        $this->amountCharged = 0;
        $this->amountToSettled = 0;
        $this->liquidationStatusId = '';
        $this->liquidationStatusName = '';
    }

    public static function fromValues(array $value): static
    {
        return new static(
            $value["reference"] ,
            $value["authorization_number"] ,
            $value["transaction_date"] ,
            $value["amount"] ,
            $value["approved"] ,
            $value["terminal_id"] ,
            $value["terminal_type"] ,
            $value["terminal_name"] ,
            $value["terminal_speiCard"] ,
            $value["terminal_shared"] ,
            $value["message"] ,
            $value["reversed"] ,
            $value["card_number"] ,
            $value["issuer"] ,
            $value["card_brand"] ,
            false
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function setConciliation(array $conciliations): void
    {
        $this->conciliated = in_array($this->id , $conciliations);
    }

    public function isTerminalPhysical(): bool
    {
        return $this->terminal_type === '2';
    }

    public function belongsToCommerceBy(array $transactionReferences): bool
    {
        return in_array($this->id , $transactionReferences);
    }

    public function isSameReference(array $transactionReferences): bool
    {
        return in_array($this->id , $transactionReferences);
    }

    public function addAdditionalData(array $transactions): void
    {
        array_map(function (array $transaction) {
            $commission = $transaction['sharedTerminalCommission'] ?? $_ENV['SHARED_TERMINAL_COMMISSION'];
            if ($this->isSameReference([$transaction['reference']])) {
                $this->commerceId = $transaction['commerceId'];
                $this->commerceName = $transaction['commerceName'];
                $this->commission = floatval($commission);
                $this->amountCharged = $this->calculateCharge();
                $this->amountToSettled = $this->calculateAmountSettled();
                $this->liquidationStatusId = $transaction['liquidationStatusId'];
                $this->liquidationStatusName = $transaction['liquidationStatusName'];
            }
        } , $transactions);
    }

    private function calculateCharge(): float
    {
        return $this->amount * $this->commission / 100;
    }

    private function calculateAmountSettled(): float
    {
        return $this->amount - $this->amountCharged;
    }

    public function isNotTerminalShared(): bool
    {
        return !$this->terminal_shared;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id ,
            'commerceId' => $this->commerceId ?? '' ,
            'commerceName' => $this->commerceName ?? '' ,
            'commission' => $this->commission ?? '' ,
            'amountCharged' => $this->amountCharged ,
            'amountToSettled' => $this->amountToSettled ,
            'authorization_number' => $this->authorization_number ,
            'transaction_date' => $this->transaction_date ,
            'amount' => $this->amount ,
            'approved' => $this->approved ,
            'terminal_id' => $this->terminal_id ,
            'terminal_type' => $this->terminal_type ,
            'terminal_name' => $this->terminal_name ,
            'terminal_spei_card' => $this->terminal_speiCard ,
            'terminal_shared' => $this->terminal_shared ,
            'liquidationStatusId' => $this->liquidationStatusId ?? '' ,
            'liquidationStatusName' => $this->liquidationStatusName ?? '' ,
            'result_message' => $this->message ,
            'reversed' => $this->reversed ,
            'card_number' => $this->card_number ,
            'issuer' => $this->issuer ,
            'card_brand' => $this->card_brand ,
            'conciliated' => $this->conciliated ,
        ];
    }
}