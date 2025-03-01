<?php declare(strict_types=1);


namespace Viabo\management\billing\domain;


use Viabo\shared\domain\utils\NumberFormat;
use Viabo\shared\domain\valueObjects\DecimalValueObject;

final class BillingCommission extends DecimalValueObject
{
    public function valueString(): string
    {
        return NumberFormat::floatString($this->value);
    }
}