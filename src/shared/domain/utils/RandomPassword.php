<?php


namespace Viabo\shared\domain\utils;


final class RandomPassword
{
    private static string $alphabet_lower_case = 'abcdefghijklmnopqrstuvwxyz';
    private static string $alphabet_upper_case = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private static string $specialCharacter = '_-.@';
    private static array $password;

    public static function get(bool $specialCharacter = false): string
    {
        self::$password = [];
        self::setFistLowerCase();
        self::setFistUpperCase();
        self::setFistNumber();
        self::setPassword();

        if ($specialCharacter) {
            self::setSpecialCharacter();
        }

        return implode(self::$password);
    }

    private static function setFistLowerCase(): void
    {
        for ($i = 0; $i < 1; $i++) {
            $n = random_int(0 , 25);
            self::$password[] = self::$alphabet_lower_case[$n];
        }
    }

    private static function setFistUpperCase(): void
    {
        for ($i = 0; $i < 1; $i++) {
            $n = random_int(0 , 25);
            self::$password[] = self::$alphabet_upper_case[$n];
        }
    }

    private static function setFistNumber(): void
    {
        for ($i = 0; $i < 1; $i++) {
            self::$password[] = random_int(0 , 9);
        }
    }

    private static function setPassword(): void
    {
        $alphaLength = strlen(self::$alphabet_lower_case) - 1;
        for ($i = 0; $i < 5; $i++) {
            $n = random_int(0 , $alphaLength);
            self::$password[] = self::$alphabet_lower_case[$n];
        }
    }

    private static function setSpecialCharacter(): void
    {
        for ($i = 0; $i < 1; $i++) {
            $n = random_int(0 , 3);
            self::$password[] = self::$specialCharacter[$n];
        }
    }
}