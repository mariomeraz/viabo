<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\card;


use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class CommissionCardSpeiOutMasterCard extends DecimalValueObject
{
    public static function empty(): static
    {
        return new static(0);
    }

    public function update(float $value): static
    {
        return new static($value);
    }

}