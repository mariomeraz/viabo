<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain;


final class CommercePayData
{
    public function __construct(
        private string $reference ,
        private string $terminalId ,
        private string $email ,
        private string $phone ,
        private string $merchantId ,
        private string $apiKey ,
        private string $amount
    )
    {
    }

    public static function empty(): static
    {
        return new static('' , '' , '' , '' , '' , '' , '');
    }

    public function toArray(): array
    {
        return [
            'reference' => $this->reference ,
            'terminalId' => $this->terminalId ,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'merchantId' => $this->merchantId ,
            'apiKey' => $this->apiKey ,
            'amount' => $this->amount
        ];
    }

}