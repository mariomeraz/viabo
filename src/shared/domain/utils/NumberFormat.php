<?php declare(strict_types=1);


namespace Viabo\shared\domain\utils;


final class NumberFormat
{
    public static function money(float $value): string
    {
        $formatted_number = number_format($value , 2);
        return '$' . $formatted_number;
    }

    public static function float(mixed $value): float
    {
        $number = number_format(floatval($value) , 2);
        return floatval(str_replace(',' , '' , $number));
    }

    public static function floatString(mixed $value): string
    {
        $number = number_format(floatval($value) , 2);
        return str_replace(',' , '' , $number);
    }
}