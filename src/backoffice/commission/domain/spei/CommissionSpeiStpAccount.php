<?php declare(strict_types=1);


namespace Viabo\backoffice\commission\domain\spei;


use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class CommissionSpeiStpAccount extends DecimalValueObject
{
    public static function empty(): static
    {
        return new static(0);
    }
}