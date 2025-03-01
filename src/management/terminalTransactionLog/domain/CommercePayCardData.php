<?php declare(strict_types=1);


namespace Viabo\management\terminalTransactionLog\domain;


final readonly class CommercePayCardData
{
    public function __construct(
        private string $cardNumber ,
        private string $expMonth ,
        private string $expYear ,
        private string $security ,
        private string $cardHolder
    )
    {
    }

    public static function empty(): static
    {
        return new static('' , '' , '' , '' , '');
    }

    public function format(): array
    {
        return [
            'reading_method' => 'key_entry' ,
            'card_number' => $this->cardNumber ,
            'exp_month' => $this->expMonth ,
            'exp_year' => $this->expYear ,
            'sec_code' => $this->security ,
            'last_four' => $this->cardNumberLastFour() ,
            'cardholder_name' => $this->cardHolder
        ];
    }

    private function cardNumberLastFour(): string
    {
        return substr($this->cardNumber , strlen($this->cardNumber) - 4 , 4);
    }
}