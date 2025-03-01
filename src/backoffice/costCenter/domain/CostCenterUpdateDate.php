<?php declare(strict_types=1);


namespace Viabo\backoffice\costCenter\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CostCenterUpdateDate extends DateTimeValueObject
{
    public static function empty(): static
    {
        $date = self::todayDate();
        $date->value = '0000-00-00 00:00:00';
        return $date;
    }
}