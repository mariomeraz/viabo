<?php declare(strict_types=1);


namespace Viabo\management\fundingOrder\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class FundingOrderCancellationDate extends DateTimeValueObject
{
    public static function empty(): static
    {
        $date = self::todayDate();
        $date->value = '0000-00-00 00:00:00';
        return $date;
    }

}