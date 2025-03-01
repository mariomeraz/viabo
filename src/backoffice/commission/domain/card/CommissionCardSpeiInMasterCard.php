<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\card;


use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class CommissionCardSpeiInMasterCard extends DecimalValueObject
{
    public static function empty(): static
    {
        return new static(0);
    }

    public function isType(string $paymentProcessor): bool
    {
        return 'mastercard' === strtolower($paymentProcessor);
    }

    public function update(float $value): static
    {
        return new static($value);
    }

}