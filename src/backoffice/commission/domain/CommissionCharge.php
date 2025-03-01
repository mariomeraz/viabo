<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain;


use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class CommissionCharge extends DecimalValueObject
{

    public function __construct(
        ?float         $value ,
        private float  $percentage ,
        private string $type
    )
    {
        parent::__construct($value);
    }

    public static function empty(): static
    {
        return new static(0 , 0 , '');
    }

    public function calculate(float $percentage , float $amount , string $type): void
    {
        $this->percentage = $percentage / 100;
        $amount = $amount * $this->percentage;
        $this->value = empty($amount) ? 0 : max($amount , 1);
        $this->type = $type;
    }

    public function toArray(): array
    {
        return [
            'percentage' => "$this->percentage%" ,
            'charge' => $this->value ,
            'type' => $this->type
        ];
    }
}