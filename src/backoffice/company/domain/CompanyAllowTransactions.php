<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyAllowTransactions extends StringValueObject
{
    public static function empty(): static
    {
        return new static('0');
    }

    public static function enable(): static
    {
        return new static('1');
    }

}