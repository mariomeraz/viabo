<?php declare(strict_types=1);


namespace Viabo\security\session\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class SessionLogoutDate extends DateTimeValueObject
{
    public static function empty(): static
    {
        return new static('0000-00-00');
    }

    public function logout(): self
    {
        return self::todayDate();
    }
}