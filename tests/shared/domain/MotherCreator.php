<?php

namespace Viabo\Tests\shared\domain;

use Faker\Factory;
use Faker\Generator;

final class MotherCreator
{
    private static Generator $faker;

    public static function random(): Generator
    {
        return self::$faker = self::$faker ?? Factory::create();
    }
}