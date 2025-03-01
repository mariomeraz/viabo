<?php declare(strict_types=1);


namespace Viabo\shared\domain\utils;


use Faker\Factory;

final class Faker
{
    public static function faker(): \Faker\Generator
    {
        return Factory::create();
    }

    public static function userName(): string
    {
        return static::faker()->userName();
    }

    public static function password(): string
    {
        return static::faker()->password();
    }

    public static function email(): string
    {
        return static::faker()->lastName();
    }

    public static function uuid(): string
    {
        return static::faker()->uuid();
    }
}