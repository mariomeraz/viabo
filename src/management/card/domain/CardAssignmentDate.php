<?php declare(strict_types=1);


namespace Viabo\management\card\domain;


use Viabo\shared\domain\valueObjects\DateTimeValueObject;

final class CardAssignmentDate extends DateTimeValueObject
{
    public static function empty(): static
    {
        return new static('0000-00-00');
    }
}