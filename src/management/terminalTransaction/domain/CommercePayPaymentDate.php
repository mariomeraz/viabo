<?php declare(strict_types=1);


namespace Viabo\management\terminalTransaction\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CommercePayPaymentDate extends DateTimeValueObject
{
    public static function empty(): CommercePayPaymentDate
    {
        $date = self::todayDate();
        $date->value = '0000-00-00 00:00:00';
        return $date;
    }

    public function update(): CommercePayPaymentDate
    {
        return static::todayDate();
    }


}