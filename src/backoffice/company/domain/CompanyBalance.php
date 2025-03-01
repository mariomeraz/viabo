<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class CompanyBalance extends DecimalValueObject
{
    public static function empty(): static
    {
        return new static(0);
    }

    public function add(float $amount): static
    {
        $balance = $this->value + $amount;
        return new static($balance);
    }

    public function decrease(float $amount): static
    {
        $balance = $this->value - $amount;
        return new static($balance);
    }

    public function increment(float $amount): static
    {
        $balance = $this->value + $amount;
        return new static($balance);
    }

}