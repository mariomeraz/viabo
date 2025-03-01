<?php declare(strict_types=1);


namespace Viabo\backoffice\company\domain;


use Viabo\shared\domain\valueObjects\StringValueObject;

final class CompanyType extends StringValueObject
{
    public static function formal(): static
    {
        return new static('1');
    }

    public static function validation(): static
    {
        return new static('2');
    }

    public function isInformal(): bool
    {
        $informalType = '2';
        return $this->value === $informalType;
    }
}