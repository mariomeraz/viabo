<?php declare(strict_types=1);


namespace Viabo\shared\domain\utils;


final class URL
{
    public static function get(): string
    {
        return self::protocol() . $_SERVER['SERVER_NAME'];
    }

    public static function protocol(): string
    {
        return self::isNotEmptyHttps() && self::isNotDisableHttps() || self::isServerPort443()
            ? "https://"
            : "http://";
    }

    private static function isNotEmptyHttps(): bool
    {
        return !empty($_SERVER['HTTPS']);
    }

    private static function isNotDisableHttps(): bool
    {
        return $_SERVER['HTTPS'] !== 'off';
    }

    private static function isServerPort443(): bool
    {
        return $_SERVER['SERVER_PORT'] == 443;
    }
}