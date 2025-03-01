<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class ServiceCreateDate extends DateTimeValueObject
{
    public static function now(): ServiceCreateDate
    {
        return self::todayDate();
    }
}
