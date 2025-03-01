<?php declare(strict_types=1);


namespace Viabo\backoffice\services\domain\new\card;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CardServiceAllowTransactions extends StringValueObject
{
    public static function enable(): static
    {
        return new static('1');
    }

}